<?php

namespace ILIAS\UI\DataTable\Component\Column\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\DataTable\Component\Column\TableColumn;
use ILIAS\UI\DataTable\Component\Data\Row\TableRowData;
use ILIAS\UI\Renderer;

/**
 * Interface TableColumnFormater
 *
 * @package ILIAS\UI\DataTable\Component\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableColumnFormater {

	/**
	 * TableColumnFormater constructor
	 */
	public function __construct();


	/**
	 * @param TableColumn $column
	 * @param Renderer    $renderer
	 * @param Container   $dic
	 *
	 * @return string
	 */
	public function formatHeader(TableColumn $column, Renderer $renderer, Container $dic): string;


	/**
	 * @param TableColumn  $column
	 * @param TableRowData $row
	 * @param Renderer     $renderer
	 * @param Container    $dic
	 *
	 * @return string
	 */
	public function formatRow(TableColumn $column, TableRowData $row, Renderer $renderer, Container $dic): string;
}
