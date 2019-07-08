<?php

namespace srag\DataTable\Implementation\Factory;

use ILIAS\DI\Container;
use srag\DataTable\Component\Column\Formater\TableColumnFormater;
use srag\DataTable\Component\Column\TableColumn as TableColumnInterface;
use srag\DataTable\Component\Data\Fetcher\TableDataFetcher;
use srag\DataTable\Component\Data\Row\TableRowData as TableRowDataInterface;
use srag\DataTable\Component\Data\TableData as TableDataInterface;
use srag\DataTable\Component\DataTable as DataTableInterface;
use srag\DataTable\Component\Export\Formater\TableExportFormater;
use srag\DataTable\Component\Export\TableExportFormat;
use srag\DataTable\Component\Factory\Factory as FactoryInterface;
use srag\DataTable\Component\Filter\Sort\TableFilterSortField as TableFilterSortFieldInterface;
use srag\DataTable\Component\Filter\Storage\TableFilterStorage;
use srag\DataTable\Component\Filter\TableFilter as TableFilterInterface;
use srag\DataTable\Implementation\Column\Action\ActionTableColumn;
use srag\DataTable\Implementation\Column\Action\ActionTableColumnFormater;
use srag\DataTable\Implementation\Column\TableColumn;
use srag\DataTable\Implementation\Data\Row\TableRowData;
use srag\DataTable\Implementation\Data\TableData;
use srag\DataTable\Implementation\DataTable;
use srag\DataTable\Implementation\Export\TableCSVTableExportFormat;
use srag\DataTable\Implementation\Export\TableExcelTableExportFormat;
use srag\DataTable\Implementation\Export\TablePDFTableExportFormat;
use srag\DataTable\Implementation\Filter\Sort\TableFilterSortField;
use srag\DataTable\Implementation\Filter\TableFilter;

/**
 * Class Factory
 *
 * @package srag\DataTable\Implementation\Factory
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Factory implements FactoryInterface {

	/**
	 * @var Container
	 */
	protected $dic;


	/**
	 * @inheritDoc
	 */
	public function __construct(Container $dic) {
		$this->dic = $dic;
	}


	/**
	 * @inheritDoc
	 */
	public function table(string $id, string $action_url, string $title, array $columns, TableDataFetcher $data_fetcher, TableFilterStorage $filter_storage): DataTableInterface {
		return new DataTable($id, $action_url, $title, $columns, $data_fetcher, $filter_storage, $this);
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
		return (new ActionTableColumn($key, $title, new ActionTableColumnFormater($this->dic)))->withActions($actions)->withSortable(false)
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
		return new TableCSVTableExportFormat($this->dic);
	}


	/**
	 * @inheritDoc
	 */
	public function exportFormatExcel(): TableExportFormat {
		return new TableExcelTableExportFormat($this->dic);
	}


	/**
	 * @inheritDoc
	 */
	public function exportFormatPDF(): TableExportFormat {
		return new TablePDFTableExportFormat($this->dic);
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
