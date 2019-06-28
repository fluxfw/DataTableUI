<?php

namespace ILIAS\UI\DataTable\Example\Column\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\DataTable\Component\Column\TableColumn;
use ILIAS\UI\DataTable\Component\Data\Row\TableRowData;
use ILIAS\UI\DataTable\Component\Export\Formater\TableExportFormater;
use ILIAS\UI\DataTable\Component\Export\TableExportFormat;
use ILIAS\UI\Renderer;
use Throwable;

/**
 * Class SimplePropertyTableExportFormater
 *
 * @package ILIAS\UI\DataTable\Example\Column\Formater
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
	public function formatHeader(TableExportFormat $export_format, TableColumn $column, Renderer $renderer, Container $dic): string {
		$value = "";

		switch ($export_format->getId()) {
			default:
				$value = $column->getTitle();
				break;
		}

		return strval($value);
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(TableExportFormat $export_format, TableColumn $column, TableRowData $row, Renderer $renderer, Container $dic): string {
		$value = "";

		switch ($export_format->getId()) {
			default:
				try {
					$value = strval($row->getOriginalData()->{$column->getKey()});
				} catch (Throwable $ex) {
					$value = "";
				}
				break;
		}

		return strval($value);
	}
}
