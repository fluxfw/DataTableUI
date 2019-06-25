<?php

namespace srag\TableUI\Example\Column\Formater;

use srag\TableUI\Component\Column\Formater\TableColumnFormater;
use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Row\TableRowData;

/**
 * Class SimpleGetterTableColumnFormater
 *
 * @package srag\TableUI\Example\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimpleGetterTableColumnFormater implements TableColumnFormater {

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
		$value = "";

		if (method_exists($row->getOriginalData(), $method = "get" . $this->strToCamelCase($column->getKey()))) {
			$value = $row->getOriginalData()->{$method}();
		}

		if (method_exists($row->getOriginalData(), $method = "is" . $this->strToCamelCase($column->getKey()))) {
			$value = $row->getOriginalData()->{$method}();
		}

		return strval($value);
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
