<?php

namespace srag\TableUI\Implementation\Column;

use srag\TableUI\Component\Column\Formater\TableColumnFormater;
use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Row\TableRowData;

/**
 * Class SimpleGetterTableColumnFormater
 *
 * @package srag\TableUI\Implementation\Column
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimpleGetterTableColumnFormater implements TableColumnFormater {

	/**
	 * SimpleGetterTableColumnFormater constructor
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
		if (method_exists($column, $method = "get" . $this->strToCamelCase($column->getKey()))) {
			return strval($column->{$method}());
		}

		if (method_exists($column, $method = "is" . $this->strToCamelCase($column->getKey()))) {
			return strval($column->{$method}());
		}

		return "";
	}


	/**
	 * @param string $string
	 *
	 * @return string
	 */
	protected function strToCamelCase(string $string): string {
		return str_replace("_", "", ucwords($string, "_"));
	}
}
