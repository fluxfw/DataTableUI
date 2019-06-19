<?php

namespace srag\TableUI\Implementation;

use ILIAS\UI\Component\Component;
use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Implementation\Render\ilTemplateWrapper;
use ILIAS\UI\Renderer as RendererInterface;
use ilTemplate;
use srag\DIC\DICTrait;
use srag\TableUI\Component\Filter\TableFilter;
use srag\TableUI\Component\TableUI as TableUIInterface;
use srag\TableUI\Implementation\Data\TableData;
use srag\TableUI\Implementation\Filter\Storage\TableFilterStorage;

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

		if (strtoupper(filter_input(INPUT_SERVER, "REQUEST_METHOD")) === "POST") {
			$sort_field = strval(filter_input(INPUT_POST, TableFilter::VAR_SORT_FIELD));
			if (!empty($sort_field)) {
				$filter = $filter->withSortField($sort_field);
			}

			$sort_field_direction = intval(filter_input(INPUT_POST, TableFilter::VAR_SORT_FIELD_DIRECTION));
			if (!empty($sort_field_direction)) {
				$filter = $filter->withSortFieldDirection($sort_field_direction);
			}

			$rows_count = intval(filter_input(INPUT_POST, TableFilter::VAR_ROWS_COUNT));
			if (!empty($rows_count)) {
				$filter = $filter->withRowsCount($rows_count);
				$filter = $filter->withCurrentPage(); // Reset current page on row change
			}

			$current_page = intval(filter_input(INPUT_POST, TableFilter::VAR_CURRENT_PAGE));
			if (!empty($current_page)) {
				$filter = $filter->withCurrentPage($current_page);
			}

			$filter = $filter->withFilterSet(true);
		}

		if (!$component->isFetchDataNeedsFilterFirstSet() || $filter->isFilterSet()) {
			$data = $component->getDataFetcher()->fetchData($filter);
		} else {
			$data = new TableData([], 0);
		}

		$dir = __DIR__;
		$dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1) . "/../..";

		self::dic()->mainTemplate()->addCss($dir . "/css/tableui.css");

		self::dic()->mainTemplate()->addJavaScript($dir . "/js/tableui.min.js");

		$tpl = new ilTemplateWrapper(self::dic()->mainTemplate(), new ilTemplate(__DIR__ . "/../../templates/table.html", true, true));

		$tpl->setVariable("ID", $component->getId());

		$tpl->setVariable("TITLE", $component->getTitle());

		$tpl->setVariable("PAGES_SELECTOR", self::output()->getHTML([
			"Pages: ",
			implode("", array_map(function (int $page) use ($component, $filter): string {
				if ($filter->getCurrentPage() === $page) {
					return strval($page);
				} else {
					return $this->postLink($component, strval($page), [
						TableFilter::VAR_CURRENT_PAGE => $page
					]);
				}
			}, range(1, $filter->getTotalPages($data->getMaxCount()))))
		]));

		$tpl->setVariable("ROWS_SELECTOR", self::output()->getHTML([
			"Rows: ",
			implode("", array_map(function (int $count) use ($component, $filter): string {
				if ($filter->getRowsCount() === $count) {
					return strval($count);
				} else {
					return $this->postLink($component, strval($count), [
						TableFilter::VAR_ROWS_COUNT => $count
					]);
				}
			}, TableFilter::ROWS_COUNT))
		]));

		$tpl->setCurrentBlock("header");
		foreach ($component->getColumns() as $column) {
			$sort_button = $column->getColumnFormater()->formatHeader($column);
			if ($column->isSortable()) {
				if ($filter->getSortField() === $column->getKey()) {
					if ($filter->getSortFieldDirection() === TableFilter::SORT_DIRECTION_DOWN) {
						$sort_button = $this->postLink($component, [ $sort_button, self::dic()->ui()->factory()->glyph()->sortDescending() ], [
							TableFilter::VAR_SORT_FIELD => $column->getKey(),
							TableFilter::VAR_SORT_FIELD_DIRECTION => TableFilter::SORT_DIRECTION_UP
						]);
					} else {
						$sort_button = $this->postLink($component, [ $sort_button, self::dic()->ui()->factory()->glyph()->sortAscending() ], [
							TableFilter::VAR_SORT_FIELD => $column->getKey(),
							TableFilter::VAR_SORT_FIELD_DIRECTION => TableFilter::SORT_DIRECTION_DOWN
						]);
					}
				} else {
					$sort_button = $this->postLink($component, $sort_button, [
						TableFilter::VAR_SORT_FIELD => $column->getKey(),
						TableFilter::VAR_SORT_FIELD_DIRECTION => TableFilter::SORT_DIRECTION_UP
					]);
				}
			}

			$tpl->setVariable("HEADER", self::output()->getHTML($sort_button));

			$tpl->parseCurrentBlock();
		}

		$tpl->setCurrentBlock("body");
		foreach ($data->getData() as $row) {
			$tpl_row = new ilTemplateWrapper(self::dic()->mainTemplate(), new ilTemplate(__DIR__ . "/../../templates/row.html", true, true));

			$tpl_row->setCurrentBlock("row");

			foreach ($component->getColumns() as $column) {
				$tpl_row->setVariable("COLUMN", $column->getColumnFormater()->formatRow($column, $row));

				$tpl_row->parseCurrentBlock();
			}

			$tpl->setVariable("ROW", self::output()->getHTML($tpl_row));

			$tpl->parseCurrentBlock();
		}

		$tpl->setVariable("COUNT", self::output()->getHTML([
			"(",
			strval($filter->getLimitStart() + 1),
			" - ",
			strval(min($filter->getLimitEnd(), $data->getMaxCount())),
			" of ",
			strval($data->getMaxCount()),
			")"
		]));

		$html = self::output()->getHTML($tpl);

		$filter_storage->store($filter);

		return $html;
	}


	/**
	 * @param TableUIInterface $component
	 * @param mixed            $label
	 * @param array            $fields
	 *
	 * @return string
	 */
	protected function postLink(TableUIInterface $component, $label, array $fields): string {
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
