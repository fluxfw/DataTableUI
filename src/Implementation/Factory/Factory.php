<?php

namespace srag\DataTable\Implementation\Factory;

use ILIAS\DI\Container;
use srag\DataTable\Component\Column\Formater\ColumnFormater;
use srag\DataTable\Component\Column\Column as ColumnInterface;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Data\Row\RowData as RowDataInterface;
use srag\DataTable\Component\Data\Data as DataInterface;
use srag\DataTable\Component\Table as TableInterface;
use srag\DataTable\Component\Export\Formater\ExportFormater;
use srag\DataTable\Component\Export\ExportFormat;
use srag\DataTable\Component\Factory\Factory as FactoryInterface;
use srag\DataTable\Component\Filter\Sort\FilterSortField as FilterSortFieldInterface;
use srag\DataTable\Component\Filter\Storage\FilterStorage;
use srag\DataTable\Component\Filter\Filter as FilterInterface;
use srag\DataTable\Implementation\Column\Action\ActionColumn;
use srag\DataTable\Implementation\Column\Action\ActionColumnFormater;
use srag\DataTable\Implementation\Column\Column;
use srag\DataTable\Implementation\Data\Row\RowData;
use srag\DataTable\Implementation\Data\Data;
use srag\DataTable\Implementation\Table;
use srag\DataTable\Implementation\Export\CSVExportFormat;
use srag\DataTable\Implementation\Export\ExcelExportFormat;
use srag\DataTable\Implementation\Export\PDFExportFormat;
use srag\DataTable\Implementation\Filter\Sort\FilterSortField;
use srag\DataTable\Implementation\Filter\Filter;

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
	public function table(string $id, string $action_url, string $title, array $columns, DataFetcher $data_fetcher, FilterStorage $filter_storage): TableInterface {
		return new Table($id, $action_url, $title, $columns, $data_fetcher, $filter_storage, $this);
	}


	/**
	 * @inheritDoc
	 */
	public function column(string $key, string $title, ColumnFormater $column_formater, ExportFormater $export_formater): ColumnInterface {
		return new Column($key, $title, $column_formater, $export_formater);
	}


	/**
	 * @inheritDoc
	 */
	public function actionColumn(string $key, string $title, array $actions): ColumnInterface {
		return (new ActionColumn($key, $title, new ActionColumnFormater($this->dic)))->withActions($actions)->withSortable(false)
			->withSelectable(false);
	}


	/**
	 * @inheritDoc
	 */
	public function data(array $data, int $max_count): DataInterface {
		return new Data($data, $max_count);
	}


	/**
	 * @inheritDoc
	 */
	public function filter(string $table_id, int $user_id): FilterInterface {
		return new Filter($table_id, $user_id);
	}


	/**
	 * @inheritDoc
	 */
	public function filterSortField(string $sort_field, int $sort_field_direction): FilterSortFieldInterface {
		return new FilterSortField($sort_field, $sort_field_direction);
	}


	/**
	 * @inheritDoc
	 */
	public function rowData(string $row_id, object $original_data): RowDataInterface {
		return new RowData($row_id, $original_data);
	}


	/**
	 * @inheritDoc
	 */
	public function exportFormatCSV(): ExportFormat {
		return new CSVExportFormat($this->dic);
	}


	/**
	 * @inheritDoc
	 */
	public function exportFormatExcel(): ExportFormat {
		return new ExcelExportFormat($this->dic);
	}


	/**
	 * @inheritDoc
	 */
	public function exportFormatPDF(): ExportFormat {
		return new PDFExportFormat($this->dic);
	}
}
