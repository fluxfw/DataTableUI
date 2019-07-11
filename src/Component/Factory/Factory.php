<?php

namespace srag\DataTable\Component\Factory;

use ILIAS\DI\Container;
use srag\DataTable\Component\Column\Formater\ColumnFormater;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Table;
use srag\DataTable\Component\Export\Formater\ExportFormater;
use srag\DataTable\Component\Export\ExportFormat;
use srag\DataTable\Component\Filter\Sort\FilterSortField;
use srag\DataTable\Component\Filter\Storage\FilterStorage;
use srag\DataTable\Component\Filter\Filter;

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
	 * @param string        $id
	 * @param string        $action_url
	 * @param string        $title
	 * @param Column[]      $columns
	 * @param DataFetcher   $data_fetcher
	 * @param FilterStorage $filter_storage
	 *
	 * @return Table
	 */
	public function table(string $id, string $action_url, string $title, array $columns, DataFetcher $data_fetcher, FilterStorage $filter_storage): Table;


	/**
	 * @param string         $key
	 * @param string         $title
	 * @param ColumnFormater $column_formater
	 * @param ExportFormater $export_formater
	 *
	 * @return Column
	 */
	public function column(string $key, string $title, ColumnFormater $column_formater, ExportFormater $export_formater): Column;


	/**
	 * @param string   $key
	 * @param string   $title
	 * @param string[] $actions
	 *
	 * @return Column
	 */
	public function actionColumn(string $key, string $title, array $actions): Column;


	/**
	 * @param RowData[] $data
	 * @param int       $max_count
	 *
	 * @return Data
	 */
	public function data(array $data, int $max_count): Data;


	/**
	 * @param string $table_id
	 * @param int    $user_id
	 *
	 * @return Filter
	 */
	public function filter(string $table_id, int $user_id): Filter;


	/**
	 * @param string $sort_field
	 * @param int    $sort_field_direction
	 *
	 * @return FilterSortField
	 */
	public function filterSortField(string $sort_field, int $sort_field_direction): FilterSortField;


	/**
	 * @param string $row_id
	 * @param object $original_data
	 *
	 * @return RowData
	 */
	public function rowData(string $row_id, object $original_data): RowData;


	/**
	 * @return ExportFormat
	 */
	public function exportFormatCSV(): ExportFormat;


	/**
	 * @return ExportFormat
	 */
	public function exportFormatExcel(): ExportFormat;


	/**
	 * @return ExportFormat
	 */
	public function exportFormatPDF(): ExportFormat;
}
