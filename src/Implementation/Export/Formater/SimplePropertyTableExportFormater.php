<?php

namespace srag\TableUI\Implementation\Column;

use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Row\TableRowData;
use srag\TableUI\Component\Export\Formater\TableExportFormater;
use srag\TableUI\Component\Export\TableExportFormat;

/**
 * Class SimplePropertyTableExportFormater
 *
 * @package srag\TableUI\Implementation\Column
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimplePropertyTableExportFormater implements TableExportFormater {

	/**
	 * @inheritDoc
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
				return strval($row->getOriginalData()->{$column->getKey()});
		}
	}
}
