<?php

namespace srag\TableUI\Implementation;

use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Input\Container\Form\Standard;
use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Implementation\Render\ilTemplateWrapper;
use ILIAS\UI\Renderer as RendererInterface;
use ilTemplate;
use srag\DIC\DICTrait;
use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\TableData as TableDataInterface;
use srag\TableUI\Component\Filter\Sort\TableFilterSortField as TableFilterSortFieldInterface;
use srag\TableUI\Component\Filter\Storage\TableFilterStorage as TableFilterStorageInterface;
use srag\TableUI\Component\Filter\TableFilter;
use srag\TableUI\Component\TableUI as TableUIInterface;
use srag\TableUI\Implementation\Data\TableData;
use srag\TableUI\Implementation\Filter\Sort\TableFilterSortField;
use srag\TableUI\Implementation\Filter\Storage\TableFilterStorage;
use Throwable;

/**
 * Class Renderer
 *
 * @package srag\TableUI\Implementation
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Renderer extends AbstractComponentRenderer {

	use DICTrait;
	/**
	 * @var Standard|null
	 */
	protected $filter_form = null;


	/**
	 * @inheritDoc
	 */
	protected function getComponentInterfaceName(): array {
		return [ TableUIInterface::class ];
	}


	/**
	 * @inheritDoc
	 */
	public function render(Component $component, RendererInterface $default_renderer) {
		$this->checkComponent($component);

		return $this->renderStandard($component, $default_renderer);
	}


	/**
	 * @param TableUIInterface  $component
	 * @param RendererInterface $default_renderer
	 *
	 * @return string
	 */
	protected function renderStandard(TableUIInterface $component, RendererInterface $default_renderer): string {
		$filter_storage = new TableFilterStorage();

		$filter = $filter_storage->read($component->getId(), self::dic()->user()->getId());

		$filter = $this->handleFilterInput($component, $filter);

		$filter = $this->handleDefaultSort($component, $filter);

		$filter = $this->handleDefaultSelectedColumns($component, $filter);

		$columns = $this->getColumns($component, $filter);

		$data = $this->handleFetchData($component, $filter);

		$dir = __DIR__;
		$dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1) . "/../..";

		self::dic()->mainTemplate()->addCss($dir . "/css/tableui.css");

		self::dic()->mainTemplate()->addJavaScript($dir . "/js/tableui.min.js");

		$tpl = new ilTemplateWrapper(self::dic()->mainTemplate(), new ilTemplate(__DIR__ . "/../../templates/table.html", true, true));

		$tpl->setVariable("ID", $component->getId());

		$tpl->setVariable("TITLE", $component->getTitle());

		$this->handleFilterForm($tpl, $component, $filter);

		$this->handlePagesSelector($tpl, $component, $filter, $data);

		$this->handleRowsPerPageSelector($tpl, $component, $filter);

		$this->handleColumnsSelector($tpl, $component, $filter);

		$tpl->setCurrentBlock("header");
		foreach ($columns as $column) {
			$sort_button = $column->getColumnFormater()->formatHeader($column);
			$remove_sort_button = "";
			if ($column->isSortable()) {
				$sort_field = $filter->getSortField($column->getKey());

				if ($sort_field !== null) {
					if ($sort_field->getSortFieldDirection() === TableFilterSortFieldInterface::SORT_DIRECTION_DOWN) {
						$sort_button = $this->createPostLink($component, [ $sort_button, self::dic()->ui()->factory()->glyph()->sortDescending() ], [
							TableFilterStorageInterface::VAR_SORT_FIELD => $column->getKey(),
							TableFilterStorageInterface::VAR_SORT_FIELD_DIRECTION => TableFilterSortFieldInterface::SORT_DIRECTION_UP
						]);
					} else {
						$sort_button = $this->createPostLink($component, [ $sort_button, self::dic()->ui()->factory()->glyph()->sortAscending() ], [
							TableFilterStorageInterface::VAR_SORT_FIELD => $column->getKey(),
							TableFilterStorageInterface::VAR_SORT_FIELD_DIRECTION => TableFilterSortFieldInterface::SORT_DIRECTION_DOWN
						]);
					}

					$remove_sort_button = $this->createPostLink($component, self::dic()->ui()->factory()->glyph()->remove(), [
						TableFilterStorageInterface::VAR_REMOVE_SORT_FIELD => $column->getKey()
					]);
				} else {
					$sort_button = $this->createPostLink($component, $sort_button, [
						TableFilterStorageInterface::VAR_SORT_FIELD => $column->getKey(),
						TableFilterStorageInterface::VAR_SORT_FIELD_DIRECTION => TableFilterSortFieldInterface::SORT_DIRECTION_UP
					]);
				}
			}

			$tpl->setVariable("HEADER", self::output()->getHTML([ $sort_button, $remove_sort_button ]));

			$tpl->parseCurrentBlock();
		}

		$tpl->setCurrentBlock("body");
		foreach ($data->getData() as $row) {
			$tpl_row = new ilTemplateWrapper(self::dic()->mainTemplate(), new ilTemplate(__DIR__ . "/../../templates/row.html", true, true));

			$tpl_row->setCurrentBlock("row");

			foreach ($columns as $column) {
				$value = $column->getColumnFormater()->formatRow($column, $row);
				if ($value === "") {
					$value = "&nbsp;";
				}

				$tpl_row->setVariable("COLUMN", $value);

				$tpl_row->parseCurrentBlock();
			}

			$tpl->setVariable("ROW", self::output()->getHTML($tpl_row));

			$tpl->parseCurrentBlock();
		}

		$this->handleDisplayCount($tpl, $filter, $data);

		$html = self::output()->getHTML($tpl);

		$filter_storage->store($filter);

		return $html;
	}


	/**
	 * @param TableUIInterface $component
	 * @param TableFilter      $filter
	 */
	protected function initFilterForm(TableUIInterface $component, TableFilter $filter): void {
		if ($this->filter_form === null) {
			$filter_fields_ = $component->getFilterFields();

			if (!empty($filter->getFieldValues())) {
				foreach ($filter_fields_ as $key => &$field) {
					try {
						$field = $field->withValue($filter->getFieldValue($key));
					} catch (Throwable $ex) {

					}
				}
			}

			$this->filter_form = self::dic()->ui()->factory()->input()->container()->form()->standard($component->getActionUrl(), $filter_fields_);
		}
	}


	/**
	 * @param TableUIInterface $component
	 * @param TableFilter      $filter
	 *
	 * @return TableFilter
	 */
	protected function handleFilterInput(TableUIInterface $component, TableFilter $filter): TableFilter {
		if (strtoupper(filter_input(INPUT_SERVER, "REQUEST_METHOD")) === "POST") {

			$sort_field = strval(filter_input(INPUT_POST, TableFilterStorageInterface::VAR_SORT_FIELD));
			$sort_field_direction = intval(filter_input(INPUT_POST, TableFilterStorageInterface::VAR_SORT_FIELD_DIRECTION));
			if (!empty($sort_field) && !empty($sort_field_direction)) {
				$filter = $filter->addSortField(new  TableFilterSortField($sort_field, $sort_field_direction));
			}

			$remove_sort_field = strval(filter_input(INPUT_POST, TableFilterStorageInterface::VAR_REMOVE_SORT_FIELD));
			if (!empty($remove_sort_field)) {
				$filter = $filter->removeSortField($remove_sort_field);
			}

			$rows_count = intval(filter_input(INPUT_POST, TableFilterStorageInterface::VAR_ROWS_COUNT));
			if (!empty($rows_count)) {
				$filter = $filter->withRowsCount($rows_count);
				$filter = $filter->withCurrentPage(); // Reset current page on row change
			}

			$current_page = intval(filter_input(INPUT_POST, TableFilterStorageInterface::VAR_CURRENT_PAGE));
			if (!empty($current_page)) {
				$filter = $filter->withCurrentPage($current_page);
			}

			$reset_filter = boolval(filter_input(INPUT_POST, TableFilterStorageInterface::VAR_RESET_FILTER));
			if ($reset_filter) {
				$filter = $filter->withFieldValues([]);
			}

			$select_column = strval(filter_input(INPUT_POST, TableFilterStorageInterface::VAR_SELECT_COLUMN));
			if (!empty($select_column)) {
				$filter = $filter->selectColumn($select_column);
			}

			$deselect_column = strval(filter_input(INPUT_POST, TableFilterStorageInterface::VAR_DESELECT_COLUMN));
			if (!empty($deselect_column)) {
				$filter = $filter->deselectColumn($deselect_column);
			}

			$this->initFilterForm($component, $filter);
			try {
				$this->filter_form = $this->filter_form->withRequest(self::dic()->http()->request());

				$field_values = $this->filter_form->getData();

				$filter = $filter->withFieldValues($field_values);
			} catch (Throwable $ex) {

			}

			$filter = $filter->withFilterSet(true);
		}

		return $filter;
	}


	/**
	 * @param TableUIInterface $component
	 * @param TableFilter      $filter
	 *
	 * @return TableFilter
	 */
	protected function handleDefaultSort(TableUIInterface $component, TableFilter $filter): TableFilter {
		if (!$filter->isFilterSet() && empty($filter->getSortFields())) {
			$filter = $filter->withSortFields(array_map(function (TableColumn $column): TableFilterSortFieldInterface {
				return new TableFilterSortField($column->getKey(), $column->getDefaultSortDirection());
			}, array_filter($component->getColumns(), function (TableColumn $column): bool {
				return $column->isDefaultSort();
			})));
		}

		return $filter;
	}


	/**
	 * @param TableUIInterface $component
	 * @param TableFilter      $filter
	 *
	 * @return TableFilter
	 */
	protected function handleDefaultSelectedColumns(TableUIInterface $component, TableFilter $filter): TableFilter {
		if (!$filter->isFilterSet() && empty($filter->getSelectedColumns())) {
			$filter = $filter->withSelectedColumns(array_map(function (TableColumn $column): string {
				return $column->getKey();
			}, array_filter($component->getColumns(), function (TableColumn $column): bool {
				return ($column->isSelectable() && $column->isDefaultSelected());
			})));
		}

		return $filter;
	}


	/**
	 * @param TableUIInterface $component
	 * @param TableFilter      $filter
	 *
	 * @return TableColumn[]
	 */
	protected function getColumns(TableUIInterface $component, TableFilter $filter): array {
		return array_filter($component->getColumns(), function (TableColumn $column) use ($filter): bool {
			if ($column->isSelectable()) {
				return in_array($column->getKey(), $filter->getSelectedColumns());
			} else {
				return true;
			}
		});
	}


	/**
	 * @param TableUIInterface $component
	 * @param TableFilter      $filter
	 *
	 * @return TableDataInterface
	 */
	protected function handleFetchData(TableUIInterface $component, TableFilter $filter): TableDataInterface {
		if (!$component->isFetchDataNeedsFilterFirstSet() || $filter->isFilterSet()) {
			$data = $component->getDataFetcher()->fetchData($filter);
		} else {
			$data = new TableData([], 0);
		}

		return $data;
	}


	/**
	 * @param ilTemplateWrapper $tpl
	 * @param TableUIInterface  $component
	 * @param TableFilter       $filter
	 */
	protected function handleFilterForm(ilTemplateWrapper $tpl, TableUIInterface $component, TableFilter $filter): void {
		$this->initFilterForm($component, $filter);

		$filter_form = self::output()->getHTML([
			"Filter: ",
			$this->filter_form,
			$this->createPostLink($component, "Reset filter", [
				TableFilterStorageInterface::VAR_RESET_FILTER => true
			])
		]);

		switch ($component->getFilterPosition()) {
			case TableFilter::FILTER_POSTION_BOTTOM:
				$tpl->setVariable("FILTER_FORM_BOTTOM", $filter_form);
				break;

			case TableFilter::FILTER_POSITION_TOP:
			default:
				$tpl->setVariable("FILTER_FORM_TOP", $filter_form);
				break;
		}
	}


	/**
	 * @param ilTemplateWrapper  $tpl
	 * @param TableUIInterface   $component
	 * @param TableFilter        $filter
	 * @param TableDataInterface $data
	 */
	protected function handlePagesSelector(ilTemplateWrapper $tpl, TableUIInterface $component, TableFilter $filter, TableDataInterface $data): void {
		$tpl->setVariable("PAGES_SELECTOR", self::output()->getHTML([
			"Pages: ",
			implode("", array_map(function (int $page) use ($component, $filter): string {
				if ($filter->getCurrentPage() === $page) {
					return strval($page);
				} else {
					return $this->createPostLink($component, strval($page), [
						TableFilterStorageInterface::VAR_CURRENT_PAGE => $page
					]);
				}
			}, range(1, $filter->getTotalPages($data->getMaxCount()))))
		]));
	}


	/**
	 * @param ilTemplateWrapper $tpl
	 * @param TableUIInterface  $component
	 * @param TableFilter       $filter
	 */
	protected function handleRowsPerPageSelector(ilTemplateWrapper $tpl, TableUIInterface $component, TableFilter $filter): void {
		$tpl->setVariable("ROWS_PER_PAGE_SELECTOR", self::output()->getHTML([
			"Rows per page: ",
			implode("", array_map(function (int $count) use ($component, $filter): string {
				if ($filter->getRowsCount() === $count) {
					return strval($count);
				} else {
					return $this->createPostLink($component, strval($count), [
						TableFilterStorageInterface::VAR_ROWS_COUNT => $count
					]);
				}
			}, TableFilter::ROWS_COUNT))
		]));
	}


	/**
	 * @param ilTemplateWrapper $tpl
	 * @param TableUIInterface  $component
	 * @param TableFilter       $filter
	 */
	protected function handleColumnsSelector(ilTemplateWrapper $tpl, TableUIInterface $component, TableFilter $filter): void {
		$tpl->setVariable("COLUMNS_SELECTOR", self::output()->getHTML([
			"Columns: ",
			implode("", array_map(function (TableColumn $column) use ($component, $filter): string {
				if (in_array($column->getKey(), $filter->getSelectedColumns())) {
					return $this->createPostLink($component, [ $column->getTitle(), self::dic()->ui()->factory()->glyph()->remove() ], [
						TableFilterStorageInterface::VAR_DESELECT_COLUMN => $column->getKey()
					]);
				} else {
					return $this->createPostLink($component, $column->getTitle(), [
						TableFilterStorageInterface::VAR_SELECT_COLUMN => $column->getKey()
					]);
				}
			}, array_filter($component->getColumns(), function (TableColumn $column): bool {
				return $column->isSelectable();
			})))
		]));
	}


	/**
	 * @param ilTemplateWrapper  $tpl
	 * @param TableFilter        $filter
	 * @param TableDataInterface $data
	 */
	protected function handleDisplayCount(ilTemplateWrapper $tpl, TableFilter $filter, TableDataInterface $data): void {
		$tpl->setVariable("COUNT", self::output()->getHTML([
			"(",
			strval($filter->getLimitStart() + 1),
			" - ",
			strval(min($filter->getLimitEnd(), $data->getMaxCount())),
			" of ",
			strval($data->getMaxCount()),
			")"
		]));
	}


	/**
	 * @param TableUIInterface $component
	 * @param mixed            $label
	 * @param array            $fields
	 *
	 * @return string
	 */
	protected function createPostLink(TableUIInterface $component, $label, array $fields): string {
		$tpl = new ilTemplateWrapper(self::dic()->mainTemplate(), new ilTemplate(__DIR__ . "/../../templates/post_link.html", true, true));

		$tpl->setVariable("ACTION_URL", $component->getActionUrl());

		$tpl->setVariable("CMD", $component->getActionCmd());

		$tpl->setVariable("LABEL", self::output()->getHTML($label));

		$tpl->setCurrentBlock("field");
		foreach ($fields as $key => $value) {
			$tpl->setVariable("NAME", $key);

			$tpl->setVariable("VALUE", $value);

			$tpl->parseCurrentBlock();
		}

		return self::output()->getHTML($tpl);
	}
}
