<?php

namespace srag\DataTable\Example\Column\Formater;

use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\TableColumn;
use srag\DataTable\Component\Data\Row\TableRowData;
use srag\DataTable\Component\Export\TableExportFormat;
use srag\DataTable\Implementation\Export\Formater\AbstractTableExportFormater;
use Throwable;

/**
 * Class SimplePropertyTableExportFormater
 *
 * @package srag\DataTable\Example\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimplePropertyTableExportFormater extends AbstractTableExportFormater {

	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableExportFormat $export_format, TableColumn $column, Renderer $renderer): string {
		$value = "";

		switch ($export_format->getId()) {
			case TableExportFormat::EXPORT_FORMAT_PDF:
				$value = "<b>{$column->getTitle()}</b>";
				break;

			default:
				$value = $column->getTitle();
				break;
		}

		return strval($value);
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(TableExportFormat $export_format, TableColumn $column, TableRowData $row, Renderer $renderer): string {
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
