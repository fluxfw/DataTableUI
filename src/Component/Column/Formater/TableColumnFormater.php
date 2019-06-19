<?php

namespace srag\TableUI\Component\Column\Formater;

use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Row\TableRowData;

/**
 * Interface TableColumnFormater
 *
 * @package srag\TableUI\Component\Column\Formater
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
	 *
	 * @return string
	 */
	public function formatHeader(TableColumn $column): string;


	/**
	 * @param TableColumn  $column
	 * @param TableRowData $row
	 *
	 * @return string
	 */
	public function formatRow(TableColumn $column, TableRowData $row): string;
}
