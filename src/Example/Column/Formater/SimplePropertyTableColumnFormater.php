<?php

namespace srag\TableUI\Example\Column\Formater;

use srag\TableUI\Component\Column\Formater\TableColumnFormater;
use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Row\TableRowData;

/**
 * Class SimplePropertyTableColumnFormater
 *
 * @package srag\TableUI\Example\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimplePropertyTableColumnFormater implements TableColumnFormater {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableColumn $column): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(TableColumn $column, TableRowData $row): string {
		$value = $row->getOriginalData()->{$column->getKey()};

		return strval($value);
	}
}
