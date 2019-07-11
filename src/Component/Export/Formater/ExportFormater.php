<?php

namespace srag\DataTable\Component\Export\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Export\ExportFormat;

/**
 * Interface ExportFormater
 *
 * @package srag\DataTable\Component\Export\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface ExportFormater {

	/**
	 * ExportFormater constructor
	 *
	 * @param Container $dic
	 */
	public function __construct(Container $dic);


	/**
	 * @param ExportFormat $export_format
	 * @param Column       $column
	 * @param string       $table_id
	 * @param Renderer     $renderer
	 *
	 * @return string
	 */
	public function formatHeader(ExportFormat $export_format, Column $column, string $table_id, Renderer $renderer): string;


	/**
	 * @param ExportFormat $export_format
	 * @param Column       $column
	 * @param RowData      $row
	 * @param string       $table_id
	 * @param Renderer     $renderer
	 *
	 * @return string
	 */
	public function formatRow(ExportFormat $export_format, Column $column, RowData $row, string $table_id, Renderer $renderer): string;
}
