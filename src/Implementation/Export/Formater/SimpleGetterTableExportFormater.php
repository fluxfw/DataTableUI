<?php

namespace srag\TableUI\Implementation\Column;

use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Row\TableRowData;
use srag\TableUI\Component\Export\Formater\TableExportFormater;
use srag\TableUI\Component\Export\TableExportFormat;

/**
 * Class SimpleGetterTableExportFormater
 *
 * @package srag\TableUI\Implementation\Column
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimpleGetterTableExportFormater implements TableExportFormater {

	/**
	 * SimpleGetterTableExportFormater constructor
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableExportFormat $export_format, TableColumn $column): string {
		switch ($export_format->getId()) {
			default:
				return $column->getTitle();
		}
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(TableExportFormat $export_format, TableColumn $column, TableRowData $row): string {
		switch ($export_format->getId()) {
			default:
				if (method_exists($column, $method = "get" . $this->strToCamelCase($column->getKey()))) {
					return strval($column->{$method}());
				}

				if (method_exists($column, $method = "is" . $this->strToCamelCase($column->getKey()))) {
					return strval($column->{$method}());
				}

				return "";
		}
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
