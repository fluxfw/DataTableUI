<?php

namespace srag\TableUI\Component\Export\Formater;

use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Row\TableRowData;
use srag\TableUI\Component\Export\TableExportFormat;

/**
 * Interface TableExportFormater
 *
 * @package srag\TableUI\Component\Export\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableExportFormater {

	/**
	 * TableExportFormater constructor
	 */
	public function __construct();


	/**
	 * @param TableExportFormat $export_format
	 * @param TableColumn       $column
	 *
	 * @return string
	 */
	public function formatHeader(TableExportFormat $export_format, TableColumn $column): string;


	/**
	 * @param TableExportFormat $export_format
	 * @param TableColumn       $column
	 * @param TableRowData      $row
	 *
	 * @return string
	 */
	public function formatRow(TableExportFormat $export_format, TableColumn $column, TableRowData $row): string;
}
