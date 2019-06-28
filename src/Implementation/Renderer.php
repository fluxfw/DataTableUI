<?php

namespace ILIAS\UI\Implementation\Table\Data;

use ILIAS\DI\Container;
use ILIAS\UI\Component\Button\Shy;
use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Input\Container\Filter\Standard as FilterStandard;
use ILIAS\UI\Component\Table\Data\Column\TableColumn;
use ILIAS\UI\Component\Table\Data\Data\TableData;
use ILIAS\UI\Component\Table\Data\DataTable;
use ILIAS\UI\Component\Table\Data\Export\TableExportFormat;
use ILIAS\UI\Component\Table\Data\Filter\Sort\TableFilterSortField;
use ILIAS\UI\Component\Table\Data\Filter\Storage\TableFilterStorage;
use ILIAS\UI\Component\Table\Data\Filter\TableFilter;
use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Implementation\Render\ilTemplateWrapper;
use ILIAS\UI\Implementation\Render\Template;
use ILIAS\UI\Renderer as RendererInterface;
use ilTemplate;
use ilUIFilterRequestAdapter;
use ilUIFilterService;
use ilUtil;
use Throwable;

/**
 * Class Renderer
 *
 * @package ILIAS\UI\Implementation\Table\Data
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Renderer extends AbstractComponentRenderer {

	/**
	 * @var FilterStandard|null
	 */
	protected $filter_form = null;
	/**
	 * @var Container
	 */
	protected $dic;


	/**
	 * @inheritDoc
	 */
	protected function getComponentInterfaceName(): array {
		return [ DataTable::class ];
	}


	/**
	 * @inheritDoc
	 */
	public function render(Component $component, RendererInterface $default_renderer): string {
		global $DIC;

		$this->dic = $DIC;

		$this->checkComponent($component);

		return $this->renderStandard($component, $default_renderer);
	}


	/**
	 * @param DataTable         $component
	 * @param RendererInterface $renderer
	 *
	 * @return string
	 */
	protected function renderStandard(DataTable $component, RendererInterface $renderer): string {
		$filter = $component->getFilterStorage()->read($component->getId(), $this->dic->user()->getId(), $component->getFactory());

		$filter = $this->handleFilterInput($component, $filter);

		$filter = $this->handleDefaultSort($component, $filter);

		$filter = $this->handleDefaultSelectedColumns($component, $filter);

		$columns = $this->getColumns($component, $filter);

		$data = $this->handleFetchData($component, $filter);

		$this->handleExport($component, $columns, $data, $renderer);

		$dir = __DIR__;
		$dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1) . "/../..";

		$this->dic->ui()->mainTemplate()->addCss($dir . "/css/datatable.css");

		$this->dic->ui()->mainTemplate()->addJavaScript($dir . "/js/datatable.min.js");

		$tpl = $this->getTemplate_("table.html", true, true);

		$tpl->setVariable("ID", $component->getId());

		$tpl->setVariable("TITLE", $component->getTitle());

		$this->handleFilterForm($tpl, $component, $filter, $renderer);

		$this->handleActionsPanel($tpl, $component, $filter, $data, $renderer);

		$this->handleColumns($tpl, $component, $columns, $filter, $renderer);

		$this->handleRows($tpl, $component, $columns, $data, $renderer);

		$this->handleDisplayCount($tpl, $filter, $data);

		$this->handleMultipleActions($tpl, $component, $renderer);

		$html = $tpl->get();

		$component->getFilterStorage()->store($filter);

		return $html;
	}


	/**
	 * @param DataTable   $component
	 * @param TableFilter $filter
	 *
	 * @return TableColumn[]
	 */
	protected function getColumns(DataTable $component, TableFilter $filter): array {
		return array_filter($component->getColumns(), function (TableColumn $column) use ($filter): bool {
			if ($column->isSelectable()) {
				return in_array($column->getKey(), $filter->getSelectedColumns());
			} else {
				return true;
			}
		});
	}


	/**
	 * @param DataTable         $component
	 * @param TableFilter       $filter
	 * @param RendererInterface $renderer
	 *
	 * @return Component
	 */
	protected function getColumnsSelector(DataTable $component, TableFilter $filter, RendererInterface $renderer): Component {
		return $this->dic->ui()->factory()->dropdown()->standard(array_map(function (TableColumn $column) use ($component, $filter, $renderer): Shy {
			return $this->dic->ui()->factory()->button()->shy($renderer->render([
				$this->dic->ui()->factory()->symbol()->glyph()->add(),
				$this->dic->ui()->factory()->legacy($column->getTitle())
			]), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorage::VAR_SELECT_COLUMN . "=" . $column->getKey()));
		}, array_filter($component->getColumns(), function (TableColumn $column) use ($filter): bool {
			return ($column->isSelectable() && !in_array($column->getKey(), $filter->getSelectedColumns()));
		})))->withLabel("Add columns"); // TODO: Translate
	}


	/**
	 * @param DataTable $component
	 *
	 * @return Component
	 */
	protected function getExportsSelector(DataTable $component): Component {
		return $this->dic->ui()->factory()->dropdown()->standard(array_map(function (TableExportFormat $export_format) use ($component): Shy {
			return $this->dic->ui()->factory()->button()
				->shy($export_format->getTitle(), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorage::VAR_EXPORT_FORMAT_ID
					. "=" . $export_format->getId()));
		}, $component->getExportFormats()))->withLabel("Export"); // TODO: Translate
	}


	/**
	 * @param DataTable         $component
	 * @param TableFilter       $filter
	 * @param TableData         $data
	 * @param RendererInterface $renderer
	 *
	 * @return Component
	 */
	protected function getPagesSelector(DataTable $component, TableFilter $filter, TableData $data, RendererInterface $renderer): Component {
		return $this->dic->ui()->factory()->dropdown()->standard(array_map(function (int $page) use ($component, $filter, $renderer): Component {
			if ($filter->getCurrentPage() === $page) {
				return $this->dic->ui()->factory()->legacy($renderer->render([
					$this->dic->ui()->factory()->symbol()->glyph()->apply(),
					$this->dic->ui()->factory()->legacy(strval($page))
				]));
			} else {
				return $this->dic->ui()->factory()->button()
					->shy(strval($page), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorage::VAR_CURRENT_PAGE . "="
						. $page));
			}
		}, range(1, $filter->getTotalPages($data->getMaxCount()))))
			->withLabel("Pages ({$filter->getCurrentPage()} of {$filter->getTotalPages($data->getMaxCount())})"); // TODO: Translate
	}


	/**
	 * @param DataTable         $component
	 * @param TableFilter       $filter
	 * @param RendererInterface $renderer
	 *
	 * @return Component
	 */
	protected function getRowsPerPageSelector(DataTable $component, TableFilter $filter, RendererInterface $renderer): Component {
		return $this->dic->ui()->factory()->dropdown()->standard(array_map(function (int $count) use ($component, $filter, $renderer): Component {
			if ($filter->getRowsCount() === $count) {
				return $this->dic->ui()->factory()->legacy($renderer->render([
					$this->dic->ui()->factory()->symbol()->glyph()->apply(),
					$this->dic->ui()->factory()->legacy(strval($count))
				]));
			} else {
				return $this->dic->ui()->factory()->button()
					->shy(strval($count), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorage::VAR_ROWS_COUNT . "="
						. $count));
			}
		}, TableFilter::ROWS_COUNT))->withLabel("Rows per page ({$filter->getRowsCount()})"); // TODO: Translate
	}


	/**
	 * @param string $name
	 * @param bool   $purge_unfilled_vars
	 * @param bool   $purge_unused_blocks
	 *
	 * @return Template
	 */
	protected function getTemplate_(string $name, bool $purge_unfilled_vars, bool $purge_unused_blocks): Template {
		// TODO:
		return new ilTemplateWrapper($this->dic->ui()->mainTemplate(), new ilTemplate(__DIR__ . "/../../templates/"
			. $name, $purge_unfilled_vars, $purge_unused_blocks));
	}


	/**
	 * @param Template          $tpl
	 * @param DataTable         $component
	 * @param TableFilter       $filter
	 * @param TableData         $data
	 * @param RendererInterface $renderer
	 */
	protected function handleActionsPanel(Template $tpl, DataTable $component, TableFilter $filter, TableData $data, RendererInterface $renderer): void {
		$tpl->setVariable("ACTIONS", $renderer->render($this->dic->ui()->factory()->panel()->standard("", [
			$this->getPagesSelector($component, $filter, $data, $renderer),
			$this->getColumnsSelector($component, $filter, $renderer),
			$this->getRowsPerPageSelector($component, $filter, $renderer),
			$this->getExportsSelector($component)
		])));
	}


	/**
	 * @param Template          $tpl
	 * @param DataTable         $component
	 * @param TableColumn[]     $columns
	 * @param TableFilter       $filter
	 * @param RendererInterface $renderer
	 */
	protected function handleColumns(Template $tpl, DataTable $component, array $columns, TableFilter $filter, RendererInterface $renderer): void {
		$tpl->setCurrentBlock("header");
		if (count($component->getMultipleActions()) > 0) {
			$tpl->setVariable("HEADER", "");

			$tpl->parseCurrentBlock();
		}
		foreach ($columns as $column) {
			$deselect_button = $this->dic->ui()->factory()->legacy("");
			$sort_button = $column->getColumnFormater()->formatHeader($column, $renderer, $this->dic);
			$remove_sort_button = $this->dic->ui()->factory()->legacy("");

			if ($column->isSelectable()) {
				$deselect_button = $this->dic->ui()->factory()->button()->shy($renderer->render($this->dic->ui()->factory()->symbol()->glyph()
					->remove()), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorage::VAR_DESELECT_COLUMN . "="
					. $column->getKey()));
			}

			if ($column->isSortable()) {
				$sort_field = $filter->getSortField($column->getKey());

				if ($sort_field !== null) {
					if ($sort_field->getSortFieldDirection() === TableFilterSortField::SORT_DIRECTION_DOWN) {
						$sort_button = $this->dic->ui()->factory()->button()->shy($renderer->render([
							$this->dic->ui()->factory()->legacy($sort_button),
							$this->dic->ui()->factory()->symbol()->glyph()->sortDescending()
						]), ilUtil::appendUrlParameterString(ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorage::VAR_SORT_FIELD
							. "=" . $column->getKey()), TableFilterStorage::VAR_SORT_FIELD_DIRECTION . "="
							. TableFilterSortField::SORT_DIRECTION_UP));
					} else {
						$sort_button = $this->dic->ui()->factory()->button()->shy($renderer->render([
							$this->dic->ui()->factory()->legacy($sort_button),
							$this->dic->ui()->factory()->symbol()->glyph()->sortAscending()
						]), ilUtil::appendUrlParameterString(ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorage::VAR_SORT_FIELD
							. "=" . $column->getKey()), TableFilterStorage::VAR_SORT_FIELD_DIRECTION . "="
							. TableFilterSortField::SORT_DIRECTION_DOWN));
					}

					$remove_sort_button = $this->dic->ui()->factory()->button()->shy($renderer->render($this->dic->ui()->factory()->symbol()->glyph()
						->back() // TODO: other icon for remove sort
					), ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorage::VAR_REMOVE_SORT_FIELD . "="
						. $column->getKey()));
				} else {
					$sort_button = $this->dic->ui()->factory()->button()
						->shy($sort_button, ilUtil::appendUrlParameterString(ilUtil::appendUrlParameterString($component->getActionUrl(), TableFilterStorage::VAR_SORT_FIELD
							. "=" . $column->getKey()), TableFilterStorage::VAR_SORT_FIELD_DIRECTION . "="
							. TableFilterSortField::SORT_DIRECTION_UP));
				}
			} else {
				$sort_button = $this->dic->ui()->factory()->legacy($sort_button);
			}

			$tpl->setVariable("HEADER", $renderer->render([ $deselect_button, $sort_button, $remove_sort_button ]));

			$tpl->parseCurrentBlock();
		}
	}


	/**
	 * @param DataTable   $component
	 * @param TableFilter $filter
	 *
	 * @return TableFilter
	 */
	protected function handleDefaultSelectedColumns(DataTable $component, TableFilter $filter): TableFilter {
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
	 * @param DataTable   $component
	 * @param TableFilter $filter
	 *
	 * @return TableFilter
	 */
	protected function handleDefaultSort(DataTable $component, TableFilter $filter): TableFilter {
		if (!$filter->isFilterSet() && empty($filter->getSortFields())) {
			$filter = $filter->withSortFields(array_map(function (TableColumn $column) use ($component): TableFilterSortField {
				return $component->getFactory()->filterSortField($column->getKey(), $column->getDefaultSortDirection());
			}, array_filter($component->getColumns(), function (TableColumn $column): bool {
				return ($column->isSortable() && $column->isDefaultSort());
			})));
		}

		return $filter;
	}


	/**
	 * @param Template    $tpl
	 * @param TableFilter $filter
	 * @param TableData   $data
	 */
	protected function handleDisplayCount(Template $tpl, TableFilter $filter, TableData $data): void {
		$tpl->setVariable("COUNT", implode("", [
			"(",
			strval($filter->getLimitStart() + 1),
			" - ",
			strval(min($filter->getLimitEnd(), $data->getMaxCount())),
			" of ",
			strval($data->getMaxCount()),
			")"
		])); // TODO: Translate
	}


	/**
	 * @param DataTable         $component
	 * @param TableColumn[]     $columns
	 * @param TableData         $data
	 * @param RendererInterface $renderer
	 */
	protected function handleExport(DataTable $component, array $columns, TableData $data, RendererInterface $renderer): void {
		$export_format_id = intval(filter_input(INPUT_GET, TableFilterStorage::VAR_EXPORT_FORMAT_ID));

		if (empty($export_format_id)) {
			return;
		}

		$export_format = current(array_filter($component->getExportFormats(), function (TableExportFormat $export_format) use ($export_format_id): bool {
			return ($export_format->getId() === $export_format_id);
		}));

		if ($export_format === null) {
			return;
		}

		$columns = array_filter($columns, function (TableColumn $column): bool {
			return ($column->getExportFormater() !== null);
		});

		$columns_ = [];
		foreach ($columns as $column) {
			$columns_[] = $column->getExportFormater()->formatHeader($export_format, $column, $renderer, $this->dic);
		}

		$rows_ = [];
		foreach ($data->getData() as $row) {
			$row_ = [];
			foreach ($columns as $column) {
				$row_[] = $column->getExportFormater()->formatRow($export_format, $column, $row, $renderer, $this->dic);
			}
			$rows_[] = $row_;
		}

		$export_format->export($columns_, $rows_, $component->getTitle(), $renderer, $this->dic);
	}


	/**
	 * @param DataTable   $component
	 * @param TableFilter $filter
	 *
	 * @return TableData
	 */
	protected function handleFetchData(DataTable $component, TableFilter $filter): TableData {
		if (!$component->isFetchDataNeedsFilterFirstSet() || $filter->isFilterSet()) {
			$data = $component->getDataFetcher()->fetchData($filter, $component->getFactory());
		} else {
			$data = $component->getFactory()->data([], 0);
		}

		return $data;
	}


	/**
	 * @param Template          $tpl
	 * @param DataTable         $component
	 * @param TableFilter       $filter
	 * @param RendererInterface $renderer
	 */
	protected function handleFilterForm(Template $tpl, DataTable $component, TableFilter $filter, RendererInterface $renderer): void {
		if (count($component->getFilterFields()) === 0) {
			return;
		}

		$this->initFilterForm($component, $filter);

		$filter_form = $renderer->render($this->filter_form);

		switch ($component->getFilterPosition()) {
			case TableFilter::FILTER_POSITION_BOTTOM:
				$tpl->setVariable("FILTER_FORM_BOTTOM", $filter_form);
				break;

			case TableFilter::FILTER_POSITION_TOP:
			default:
				$tpl->setVariable("FILTER_FORM_TOP", $filter_form);
				break;
		}
	}


	/**
	 * @param DataTable   $component
	 * @param TableFilter $filter
	 *
	 * @return TableFilter
	 */
	protected function handleFilterInput(DataTable $component, TableFilter $filter): TableFilter {
		//if (strtoupper(filter_input(INPUT_SERVER, "REQUEST_METHOD")) === "POST") {

		$sort_field = strval(filter_input(INPUT_GET, TableFilterStorage::VAR_SORT_FIELD));
		$sort_field_direction = intval(filter_input(INPUT_GET, TableFilterStorage::VAR_SORT_FIELD_DIRECTION));
		if (!empty($sort_field) && !empty($sort_field_direction)) {
			$filter = $filter->addSortField($component->getFactory()->filterSortField($sort_field, $sort_field_direction));

			$filter = $filter->withFilterSet(true);
		}

		$remove_sort_field = strval(filter_input(INPUT_GET, TableFilterStorage::VAR_REMOVE_SORT_FIELD));
		if (!empty($remove_sort_field)) {
			$filter = $filter->removeSortField($remove_sort_field);

			$filter = $filter->withFilterSet(true);
		}

		$rows_count = intval(filter_input(INPUT_GET, TableFilterStorage::VAR_ROWS_COUNT));
		if (!empty($rows_count)) {
			$filter = $filter->withRowsCount($rows_count);
			$filter = $filter->withCurrentPage(); // Reset current page on row change
		}

		$current_page = intval(filter_input(INPUT_GET, TableFilterStorage::VAR_CURRENT_PAGE));
		if (!empty($current_page)) {
			$filter = $filter->withCurrentPage($current_page);

			$filter = $filter->withFilterSet(true);
		}

		$select_column = strval(filter_input(INPUT_GET, TableFilterStorage::VAR_SELECT_COLUMN));
		if (!empty($select_column)) {
			$filter = $filter->selectColumn($select_column);

			$filter = $filter->withFilterSet(true);
		}

		$deselect_column = strval(filter_input(INPUT_GET, TableFilterStorage::VAR_DESELECT_COLUMN));
		if (!empty($deselect_column)) {
			$filter = $filter->deselectColumn($deselect_column);

			$filter = $filter->withFilterSet(true);
		}

		if (count($component->getFilterFields()) > 0) {
			$this->initFilterForm($component, $filter);
			try {
				$data = $this->dic->uiService()->filter()->getData($this->filter_form);

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
		}

		return $filter;
	}


	/**
	 * @param Template          $tpl
	 * @param DataTable         $component
	 * @param RendererInterface $renderer
	 */
	protected function handleMultipleActions(Template $tpl, DataTable $component, RendererInterface $renderer): void {
		if (count($component->getMultipleActions()) === 0) {
			return;
		}

		$tpl_checkbox = $this->getTemplate_("checkbox.html", true, true);

		$tpl_checkbox->setVariable("TXT", "Select all"); // TODO: Translate

		// TODO: No inline js code
		$tpl_checkbox->setVariable("ON_CHANGE", ' onchange="il.Util.setChecked(\'' . $component->getId() . '\', \''
			. DataTable::MULTIPLE_SELECT_POST_VAR . '\', this.checked);"');

		$tpl->setVariable("MULTIPLE_ACTIONS", $renderer->render([
			$this->dic->ui()->factory()->legacy($tpl_checkbox->get()),
			$this->dic->ui()->factory()->dropdown()->standard(array_map(function (string $title, string $action): Shy {
				return $this->dic->ui()->factory()->button()->shy($title, $action, DataTable::ACTION_GET_VAR);
			}, array_keys($component->getMultipleActions()), $component->getMultipleActions()))->withLabel("Multiple actions") // TODO: Translate
		]));
	}


	/**
	 * @param Template          $tpl
	 * @param DataTable         $component
	 * @param TableColumn[]     $columns
	 * @param TableData         $data
	 * @param RendererInterface $renderer
	 */
	protected function handleRows(Template $tpl, DataTable $component, array $columns, TableData $data, RendererInterface $renderer): void {
		$tpl->setCurrentBlock("body");
		foreach ($data->getData() as $row) {
			$tpl_row = $this->getTemplate_("row.html", true, true);

			$tpl_row->setCurrentBlock("row");

			if (count($component->getMultipleActions()) > 0) {
				$tpl_checkbox = $this->getTemplate_("checkbox.html", true, true);

				$tpl_checkbox->setVariable("POST_VAR", DataTable::MULTIPLE_SELECT_POST_VAR . "[]");

				$tpl_checkbox->setVariable("ROW_ID", $row->getRowId());

				$tpl_row->setVariable("COLUMN", $tpl_checkbox->get());

				$tpl_row->parseCurrentBlock();
			}

			foreach ($columns as $column) {
				$value = $column->getColumnFormater()->formatRow($column, $row, $renderer, $this->dic);

				if ($value === "") {
					$value = "&nbsp;";
				}

				$tpl_row->setVariable("COLUMN", $value);

				$tpl_row->parseCurrentBlock();
			}

			$tpl->setVariable("ROW", $tpl_row->get());

			$tpl->parseCurrentBlock();
		}
	}


	/**
	 * @param DataTable   $component
	 * @param TableFilter $filter
	 */
	protected function initFilterForm(DataTable $component, TableFilter $filter): void {
		if ($this->filter_form === null) {
			$filter_fields = $component->getFilterFields();

			$this->filter_form = $this->dic->uiService()->filter()
				->standard($component->getId(), $component->getActionUrl(), $filter_fields, array_fill(0, count($filter_fields), false), true, true);
		}
	}
}
