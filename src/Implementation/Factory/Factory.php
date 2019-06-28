<?php

namespace ILIAS\UI\DataTable\Implementation\Factory;

use ILIAS\UI\DataTable\Component\Column\Formater\TableColumnFormater;
use ILIAS\UI\DataTable\Component\Column\TableColumn as TableColumnInterface;
use ILIAS\UI\DataTable\Component\Data\Fetcher\TableDataFetcher;
use ILIAS\UI\DataTable\Component\Data\Row\TableRowData as TableRowDataInterface;
use ILIAS\UI\DataTable\Component\Data\TableData as TableDataInterface;
use ILIAS\UI\DataTable\Component\DataTable as DataTableInterface;
use ILIAS\UI\DataTable\Component\Export\Formater\TableExportFormater;
use ILIAS\UI\DataTable\Component\Export\TableExportFormat;
use ILIAS\UI\DataTable\Component\Factory\Factory as FactoryInterface;
use ILIAS\UI\DataTable\Component\Filter\Sort\TableFilterSortField as TableFilterSortFieldInterface;
use ILIAS\UI\DataTable\Component\Filter\TableFilter as TableFilterInterface;
use ILIAS\UI\DataTable\Implementation\Column\Action\ActionTableColumn;
use ILIAS\UI\DataTable\Implementation\Column\Action\ActionTableColumnFormater;
use ILIAS\UI\DataTable\Implementation\Column\TableColumn;
use ILIAS\UI\DataTable\Implementation\Data\Row\TableRowData;
use ILIAS\UI\DataTable\Implementation\Data\TableData;
use ILIAS\UI\DataTable\Implementation\DataTable;
use ILIAS\UI\DataTable\Implementation\Export\TableCSVExportFormat;
use ILIAS\UI\DataTable\Implementation\Export\TableExcelExportFormat;
use ILIAS\UI\DataTable\Implementation\Export\TablePDFExportFormat;
use ILIAS\UI\DataTable\Implementation\Filter\Sort\TableFilterSortField;
use ILIAS\UI\DataTable\Implementation\Filter\TableFilter;

/**
 * Class Factory
 *
 * @package ILIAS\UI\DataTable\Implementation\Factory
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Factory implements FactoryInterface {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function table(string $id, string $action_url, string $title, array $columns, TableDataFetcher $data_fetcher): DataTableInterface {
		return new DataTable($id, $action_url, $title, $columns, $data_fetcher);
	}


	/**
	 * @inheritDoc
	 */
	public function column(string $key, string $title, TableColumnFormater $column_formater, TableExportFormater $export_formater): TableColumnInterface {
		return new TableColumn($key, $title, $column_formater, $export_formater);
	}


	/**
	 * @inheritDoc
	 */
	public function actionColumn(string $key, string $title, array $actions): TableColumnInterface {
		return (new ActionTableColumn($key, $title, new ActionTableColumnFormater()))->withActions($actions)->withSortable(false)
			->withSelectable(false);
	}


	/**
	 * @inheritDoc
	 */
	public function data(array $data, int $max_count): TableDataInterface {
		return new TableData($data, $max_count);
	}


	/**
	 * @inheritDoc
	 */
	public function filter(string $table_id, int $user_id): TableFilterInterface {
		return new TableFilter($table_id, $user_id);
	}


	/**
	 * @inheritDoc
	 */
	public function filterSortField(string $sort_field, int $sort_field_direction): TableFilterSortFieldInterface {
		return new TableFilterSortField($sort_field, $sort_field_direction);
	}


	/**
	 * @inheritDoc
	 */
	public function rowData(string $row_id, object $original_data): TableRowDataInterface {
		return new TableRowData($row_id, $original_data);
	}


	/**
	 * @inheritDoc
	 */
	public function exportFormatCSV(): TableExportFormat {
		return new TableCSVExportFormat();
	}


	/**
	 * @inheritDoc
	 */
	public function exportFormatExcel(): TableExportFormat {
		return new TableExcelExportFormat();
	}


	/**
	 * @inheritDoc
	 */
	public function exportFormatPDF(): TableExportFormat {
		return new TablePDFExportFormat();
	}


	/**
	 * @inheritDoc
	 */
	public function getActionRowId(): string {
		return strval(filter_input(INPUT_GET, DataTableInterface::ACTION_GET_VAR));
	}


	/**
	 * @inheritDoc
	 */
	public function getMultipleActionRowIds(): array {
		return (filter_input(INPUT_POST, DataTableInterface::MULTIPLE_SELECT_POST_VAR, FILTER_DEFAULT, FILTER_FORCE_ARRAY) ?? []);
	}
}
