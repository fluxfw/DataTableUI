<?php

namespace srag\TableUI\Implementation;

use ILIAS\UI\Component\Button\Shy;
use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Input\Container\Filter\Standard as FilterStandard;
use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Implementation\Render\ilTemplateWrapper;
use ILIAS\UI\Renderer as RendererInterface;
use ilTemplate;
use ilUIFilterRequestAdapter;
use ilUIFilterService;
use ilUtil;
use srag\DIC\DICTrait;
use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\TableData as TableDataInterface;
use srag\TableUI\Component\Export\TableExportFormat;
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
	 * @var FilterStandard|null
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

		$this->handleExport($component, $columns, $data);

		$dir = __DIR__;
		$dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1) . "/../..";

		self::dic()->mainTemplate()->addCss($dir . "/css/tableui.css");

		self::dic()->mainTemplate()->addJavaScript($dir . "/js/tableui.min.js");

		$tpl = new ilTemplateWrapper(self::dic()->mainTemplate(), new ilTemplate(__DIR__ . "/../../templates/table.html", true, true));

		$tpl->setVariable("ID", $component->getId());

		$tpl->setVariable("TITLE", $component->getTitle());

		$this->handleFilterForm($tpl, $component, $filter);

		$this->handleActionsPanel($tpl, $component, $filter, $data);

		$tpl->setCurrentBlock("header");
		foreach ($columns as $column) {
			$deselect_button = "";
			$sort_button = $column->getColumnFormater()->formatHeader($column);
			$remove_sort_button = "";

			if ($column->isSelectable()) {
				$deselect_button = self::dic()->ui()->factory()->button()->shy(self::output()->getHTML(self::dic()->ui()->factory()->symbol()->glyph()
					->remove()), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorageInterface::VAR_DESELECT_COLUMN . "="
					. $column->getKey()));
			}

			if ($column->isSortable()) {
				$sort_field = $filter->getSortField($column->getKey());

				if ($sort_field !== null) {
					if ($sort_field->getSortFieldDirection() === TableFilterSortFieldInterface::SORT_DIRECTION_DOWN) {
						$sort_button = self::dic()->ui()->factory()->button()->shy(self::output()->getHTML([
							$sort_button,
							self::dic()->ui()->factory()->symbol()->glyph()->sortDescending()
						]), ilUtil::appendUrlParameterString(ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorageInterface::VAR_SORT_FIELD
							. "=" . $column->getKey()), TableFilterStorageInterface::VAR_SORT_FIELD_DIRECTION . "="
							. TableFilterSortFieldInterface::SORT_DIRECTION_UP));
					} else {
						$sort_button = self::dic()->ui()->factory()->button()->shy(self::output()->getHTML([
							$sort_button,
							self::dic()->ui()->factory()->symbol()->glyph()->sortAscending()
						]), ilUtil::appendUrlParameterString(ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorageInterface::VAR_SORT_FIELD
							. "=" . $column->getKey()), TableFilterStorageInterface::VAR_SORT_FIELD_DIRECTION . "="
							. TableFilterSortFieldInterface::SORT_DIRECTION_DOWN));
					}

					$remove_sort_button = self::dic()->ui()->factory()->button()->shy(self::output()->getHTML(self::dic()->ui()->factory()->symbol()
						->glyph()->back() // TODO: other icon for remove sort
					), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorageInterface::VAR_REMOVE_SORT_FIELD . "="
						. $column->getKey()));
				} else {
					$sort_button = self::dic()->ui()->factory()->button()
						->shy($sort_button, ilUtil::appendUrlParameterString(ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorageInterface::VAR_SORT_FIELD
							. "=" . $column->getKey()), TableFilterStorageInterface::VAR_SORT_FIELD_DIRECTION . "="
							. TableFilterSortFieldInterface::SORT_DIRECTION_UP));
				}
			}

			$tpl->setVariable("HEADER", self::output()->getHTML([ $deselect_button, $sort_button, $remove_sort_button ]));

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
			$filter_fields = $component->getFilterFields();

			$this->filter_form = self::dic()->uiService()->filter()
				->standard($component->getId(), $component->getActionUrl(), $filter_fields, array_fill(0, count($filter_fields), false), true, true);
		}
	}


	/**
	 * @param TableUIInterface $component
	 * @param TableFilter      $filter
	 *
	 * @return TableFilter
	 */
	protected function handleFilterInput(TableUIInterface $component, TableFilter $filter): TableFilter {
		//if (strtoupper(filter_input(INPUT_SERVER, "REQUEST_METHOD")) === "POST") {

		$sort_field = strval(filter_input(INPUT_GET, TableFilterStorageInterface::VAR_SORT_FIELD));
		$sort_field_direction = intval(filter_input(INPUT_GET, TableFilterStorageInterface::VAR_SORT_FIELD_DIRECTION));
		if (!empty($sort_field) && !empty($sort_field_direction)) {
			$filter = $filter->addSortField(new  TableFilterSortField($sort_field, $sort_field_direction));

			$filter = $filter->withFilterSet(true);
		}

		$remove_sort_field = strval(filter_input(INPUT_GET, TableFilterStorageInterface::VAR_REMOVE_SORT_FIELD));
		if (!empty($remove_sort_field)) {
			$filter = $filter->removeSortField($remove_sort_field);

			$filter = $filter->withFilterSet(true);
		}

		$rows_count = intval(filter_input(INPUT_GET, TableFilterStorageInterface::VAR_ROWS_COUNT));
		if (!empty($rows_count)) {
			$filter = $filter->withRowsCount($rows_count);
			$filter = $filter->withCurrentPage(); // Reset current page on row change
		}

		$current_page = intval(filter_input(INPUT_GET, TableFilterStorageInterface::VAR_CURRENT_PAGE));
		if (!empty($current_page)) {
			$filter = $filter->withCurrentPage($current_page);

			$filter = $filter->withFilterSet(true);
		}

		$select_column = strval(filter_input(INPUT_GET, TableFilterStorageInterface::VAR_SELECT_COLUMN));
		if (!empty($select_column)) {
			$filter = $filter->selectColumn($select_column);

			$filter = $filter->withFilterSet(true);
		}

		$deselect_column = strval(filter_input(INPUT_GET, TableFilterStorageInterface::VAR_DESELECT_COLUMN));
		if (!empty($deselect_column)) {
			$filter = $filter->deselectColumn($deselect_column);

			$filter = $filter->withFilterSet(true);
		}

		$this->initFilterForm($component, $filter);
		try {
			$data = self::dic()->uiService()->filter()->getData($this->filter_form);

			// TODO: Bug? On reset filter and on normal table load, the data is no array. But it should only empty the filter, on reset, not on normal load
			if (!is_array($data)) {
				if (filter_input(INPUT_GET, ilUIFilterRequestAdapter::CMD_PARAMETER) === ilUIFilterService::CMD_RESET) {
					$data = [];
				}
			}

			if (is_array($data)) {
				$filter = $filter->withFieldValues($data);

				$filter = $filter->withFilterSet(true);
			}
		} catch (Throwable $ex) {

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

		$filter_form = self::output()->getHTML($this->filter_form);

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
	protected function handleActionsPanel(ilTemplateWrapper $tpl, TableUIInterface $component, TableFilter $filter, TableDataInterface $data): void {
		$tpl->setVariable("ACTIONS", self::output()->getHTML(self::dic()->ui()->factory()->panel()->standard("", [
			$this->getPagesSelector($component, $filter, $data),
			$this->getColumnsSelector($component, $filter),
			$this->getRowsPerPageSelector($component, $filter),
			$this->getExportsSelector($component)
		])));
	}


	/**
	 * @param TableUIInterface   $component
	 * @param TableFilter        $filter
	 * @param TableDataInterface $data
	 *
	 * @return Component
	 */
	protected function getPagesSelector(TableUIInterface $component, TableFilter $filter, TableDataInterface $data): Component {
		return self::dic()->ui()->factory()->dropdown()->standard(array_map(function (int $page) use ($component, $filter): Component {
			if ($filter->getCurrentPage() === $page) {
				return self::dic()->ui()->factory()->legacy(self::output()->getHTML([
					self::dic()->ui()->factory()->symbol()->glyph()->apply(),
					strval($page)
				]));
			} else {
				return self::dic()->ui()->factory()->button()
					->shy(strval($page), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorageInterface::VAR_CURRENT_PAGE
						. "=" . $page));
			}
		}, range(1, $filter->getTotalPages($data->getMaxCount()))))
			->withLabel("Pages ({$filter->getCurrentPage()} of {$filter->getTotalPages($data->getMaxCount())})");
	}


	/**
	 * @param TableUIInterface $component
	 * @param TableFilter      $filter
	 *
	 * @return Component
	 */
	protected function getColumnsSelector(TableUIInterface $component, TableFilter $filter): Component {
		return self::dic()->ui()->factory()->dropdown()->standard(array_map(function (TableColumn $column) use ($component, $filter): Shy {
			return self::dic()->ui()->factory()->button()->shy(self::output()->getHTML([
				self::dic()->ui()->factory()->symbol()->glyph()->add(),
				$column->getTitle()
			]), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorageInterface::VAR_SELECT_COLUMN . "="
				. $column->getKey()));
		}, array_filter($component->getColumns(), function (TableColumn $column) use ($filter): bool {
			return ($column->isSelectable() && !in_array($column->getKey(), $filter->getSelectedColumns()));
		})))->withLabel("Add columns");
	}


	/**
	 * @param TableUIInterface $component
	 * @param TableFilter      $filter
	 *
	 * @return Component
	 */
	protected function getRowsPerPageSelector(TableUIInterface $component, TableFilter $filter): Component {
		return self::dic()->ui()->factory()->dropdown()->standard(array_map(function (int $count) use ($component, $filter): Component {
			if ($filter->getRowsCount() === $count) {
				return self::dic()->ui()->factory()->legacy(self::output()->getHTML([
					self::dic()->ui()->factory()->symbol()->glyph()->apply(),
					strval($count)
				]));
			} else {
				return self::dic()->ui()->factory()->button()
					->shy(strval($count), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorageInterface::VAR_ROWS_COUNT
						. "=" . $count));
			}
		}, TableFilter::ROWS_COUNT))->withLabel("Rows per page ({$filter->getRowsCount()})");
	}


	/**
	 * @param TableUIInterface $component
	 *
	 * @return Component
	 */
	protected function getExportsSelector(TableUIInterface $component): Component {
		return self::dic()->ui()->factory()->dropdown()->standard(array_map(function (TableExportFormat $export_format) use ($component): Shy {
			return self::dic()->ui()->factory()->button()
				->shy($export_format->getTitle(), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorageInterface::VAR_EXPORT_FORMAT_ID
					. "=" . $export_format->getId()));
		}, $component->getExportFormats()))->withLabel("Export");
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
	 * @param TableUIInterface   $component
	 * @param TableColumn[]      $columns
	 * @param TableDataInterface $data
	 */
	protected function handleExport(TableUIInterface $component, array $columns, TableDataInterface $data): void {
		$export_format_id = intval(filter_input(INPUT_GET, TableFilterStorageInterface::VAR_EXPORT_FORMAT_ID));

		if (!empty($export_format_id)) {

			$export_format = current(array_filter($component->getExportFormats(), function (TableExportFormat $export_format) use ($export_format_id): bool {
				return ($export_format->getId() === $export_format_id);
			}));

			if ($export_format !== null) {

				$columns_ = [];
				foreach ($columns as $column) {
					$columns_[] = $column->getExportFormater()->formatHeader($export_format, $column);
				}

				$rows_ = [];
				foreach ($data->getData() as $row) {
					$row_ = [];
					foreach ($columns as $column) {
						$row_[] = $column->getExportFormater()->formatRow($export_format, $column, $row);
					}
					$rows_[] = $row_;
				}

				$export_format->export($columns_, $rows_);
			}
		}
	}
}
