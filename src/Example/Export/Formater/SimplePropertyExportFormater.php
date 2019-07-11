<?php

namespace srag\DataTable\Example\Column\Formater;

use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Export\ExportFormat;
use srag\DataTable\Implementation\Export\Formater\AbstractExportFormater;
use Throwable;

/**
 * Class SimplePropertyExportFormater
 *
 * @package srag\DataTable\Example\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimplePropertyExportFormater extends AbstractExportFormater {

	/**
	 * @inheritDoc
	 */
	public function formatHeader(ExportFormat $export_format, Column $column, string $table_id, Renderer $renderer): string {
		$value = "";

		switch ($export_format->getExportId()) {
			case ExportFormat::EXPORT_FORMAT_PDF:
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
	public function formatRow(ExportFormat $export_format, Column $column, RowData $row, string $table_id, Renderer $renderer): string {
		$value = "";

		switch ($export_format->getExportId()) {
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
