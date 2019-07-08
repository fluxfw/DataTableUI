<?php

namespace srag\DataTable\Component\Export\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\TableColumn;
use srag\DataTable\Component\Data\Row\TableRowData;
use srag\DataTable\Component\Export\TableExportFormat;

/**
 * Interface TableExportFormater
 *
 * @package srag\DataTable\Component\Export\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableExportFormater {

	/**
	 * TableExportFormater constructor
	 *
	 * @param Container $dic
	 */
	public function __construct(Container $dic);


	/**
	 * @param TableExportFormat $export_format
	 * @param TableColumn       $column
	 * @param string            $table_id
	 * @param Renderer          $renderer
	 *
	 * @return string
	 */
	public function formatHeader(TableExportFormat $export_format, TableColumn $column, string $table_id, Renderer $renderer): string;


	/**
	 * @param TableExportFormat $export_format
	 * @param TableColumn       $column
	 * @param TableRowData      $row
	 * @param string            $table_id
	 * @param Renderer          $renderer
	 *
	 * @return string
	 */
	public function formatRow(TableExportFormat $export_format, TableColumn $column, TableRowData $row, string $table_id, Renderer $renderer): string;
}
