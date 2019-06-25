<?php

namespace srag\TableUI\Implementation;

use srag\TableUI\Component\Column\Formater\TableColumnFormater;
use srag\TableUI\Component\Column\TableColumn as TableColumnInterface;
use srag\TableUI\Component\Data\Fetcher\TableDataFetcher;
use srag\TableUI\Component\Data\Row\TableRowData as TableRowDataInterface;
use srag\TableUI\Component\Data\TableData as TableDataInterface;
use srag\TableUI\Component\Export\Formater\TableExportFormater;
use srag\TableUI\Component\Export\TableExportFormat;
use srag\TableUI\Component\Factory as FactoryInterface;
use srag\TableUI\Component\Filter\Sort\TableFilterSortField as TableFilterSortFieldInterface;
use srag\TableUI\Component\Filter\Storage\TableFilterStorage as TableFilterStorageInterface;
use srag\TableUI\Component\Filter\TableFilter as TableFilterInterface;
use srag\TableUI\Component\Table as TableUIInterface;
use srag\TableUI\Implementation\Column\Action\ActionTableColumn;
use srag\TableUI\Implementation\Column\Action\ActionTableColumnFormater;
use srag\TableUI\Implementation\Column\TableColumn;
use srag\TableUI\Implementation\Data\Row\TableRowData;
use srag\TableUI\Implementation\Data\TableData;
use srag\TableUI\Implementation\Export\TableCSVExportFormat;
use srag\TableUI\Implementation\Export\TableExcelExportFormat;
use srag\TableUI\Implementation\Export\TablePDFExportFormat;
use srag\TableUI\Implementation\Filter\Sort\TableFilterSortField;
use srag\TableUI\Implementation\Filter\Storage\TableFilterStorage;
use srag\TableUI\Implementation\Filter\TableFilter;

/**
 * Class Factory
 *
 * @package srag\TableUI\Implementation
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
	public function table(string $id, string $action_url, string $title, array $columns, TableDataFetcher $data_fetcher): TableUIInterface {
		return new Table($id, $action_url, $title, $columns, $data_fetcher);
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
	public function filterStorage(): TableFilterStorageInterface {
		return new TableFilterStorage();
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
		return strval(filter_input(INPUT_GET, TableUIInterface::ACTION_GET_VAR));
	}


	/**
	 * @inheritDoc
	 */
	public function getMultipleActionRowIds(): array {
		return (filter_input(INPUT_POST, TableUIInterface::MULTIPLE_SELECT_POST_VAR, FILTER_DEFAULT, FILTER_FORCE_ARRAY) ?? []);
	}
}
