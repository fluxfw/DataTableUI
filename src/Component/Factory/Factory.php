<?php

namespace srag\DataTable\Component\Factory;

use ILIAS\DI\Container;
use srag\DataTable\Component\Column\Formater\TableColumnFormater;
use srag\DataTable\Component\Column\TableColumn;
use srag\DataTable\Component\Data\Fetcher\TableDataFetcher;
use srag\DataTable\Component\Data\Row\TableRowData;
use srag\DataTable\Component\Data\TableData;
use srag\DataTable\Component\DataTable;
use srag\DataTable\Component\Export\Formater\TableExportFormater;
use srag\DataTable\Component\Export\TableExportFormat;
use srag\DataTable\Component\Filter\Sort\TableFilterSortField;
use srag\DataTable\Component\Filter\Storage\TableFilterStorage;
use srag\DataTable\Component\Filter\TableFilter;

/**
 * Interface Factory
 *
 * @package srag\DataTable\Component\Factory
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Factory {

	/**
	 * Factory constructor
	 *
	 * @param Container $dic
	 */
	public function __construct(Container $dic);


	/**
	 * @param string             $id
	 * @param string             $action_url
	 * @param string             $title
	 * @param TableColumn[]      $columns
	 * @param TableDataFetcher   $data_fetcher
	 * @param TableFilterStorage $filter_storage
	 *
	 * @return DataTable
	 */
	public function table(string $id, string $action_url, string $title, array $columns, TableDataFetcher $data_fetcher, TableFilterStorage $filter_storage): DataTable;


	/**
	 * @param string              $key
	 * @param string              $title
	 * @param TableColumnFormater $column_formater
	 * @param TableExportFormater $export_formater
	 *
	 * @return TableColumn
	 */
	public function column(string $key, string $title, TableColumnFormater $column_formater, TableExportFormater $export_formater): TableColumn;


	/**
	 * @param string   $key
	 * @param string   $title
	 * @param string[] $actions
	 *
	 * @return TableColumn
	 */
	public function actionColumn(string $key, string $title, array $actions): TableColumn;


	/**
	 * @param TableRowData[] $data
	 * @param int            $max_count
	 *
	 * @return TableData
	 */
	public function data(array $data, int $max_count): TableData;


	/**
	 * @param string $table_id
	 * @param int    $user_id
	 *
	 * @return TableFilter
	 */
	public function filter(string $table_id, int $user_id): TableFilter;


	/**
	 * @param string $sort_field
	 * @param int    $sort_field_direction
	 *
	 * @return TableFilterSortField
	 */
	public function filterSortField(string $sort_field, int $sort_field_direction): TableFilterSortField;


	/**
	 * @param string $row_id
	 * @param object $original_data
	 *
	 * @return TableRowData
	 */
	public function rowData(string $row_id, object $original_data): TableRowData;


	/**
	 * @return TableExportFormat
	 */
	public function exportFormatCSV(): TableExportFormat;


	/**
	 * @return TableExportFormat
	 */
	public function exportFormatExcel(): TableExportFormat;


	/**
	 * @return TableExportFormat
	 */
	public function exportFormatPDF(): TableExportFormat;


	/**
	 * @return string
	 */
	public function getActionRowId(): string;


	/**
	 * @return string[]
	 */
	public function getMultipleActionRowIds(): array;
}
