<?php

namespace srag\DataTable\Component\Column\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\TableColumn;
use srag\DataTable\Component\Data\Row\TableRowData;

/**
 * Interface TableColumnFormater
 *
 * @package srag\DataTable\Component\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableColumnFormater {

	/**
	 * TableColumnFormater constructor
	 *
	 * @param Container $dic
	 */
	public function __construct(Container $dic);


	/**
	 * @param TableColumn $column
	 * @param string      $table_id
	 * @param Renderer    $renderer
	 *
	 * @return string
	 */
	public function formatHeader(TableColumn $column, string $table_id, Renderer $renderer): string;


	/**
	 * @param TableColumn  $column
	 * @param TableRowData $row
	 * @param string       $table_id
	 * @param Renderer     $renderer
	 *
	 * @return string
	 */
	public function formatRow(TableColumn $column, TableRowData $row, string $table_id, Renderer $renderer): string;
}
