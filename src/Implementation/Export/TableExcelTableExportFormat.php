<?php

namespace srag\DataTable\Implementation\Export;

use ilExcel;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\DataTable;

/**
 * Class TableExcelExportFormat
 *
 * @package srag\DataTable\Implementation\Export
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TableExcelTableExportFormat extends AbstractTableExportFormat {

	/**
	 * @inheritDoc
	 */
	public function getId(): int {
		return self::EXPORT_FORMAT_EXCEL;
	}


	/**
	 * @inheritDoc
	 */
	public function getTitle(): string {
		return $this->dic->language()->txt(DataTable::LANG_MODULE . "_export_excel");
	}


	/**
	 * @inheritDoc
	 */
	public function export(array $columns, array $rows, string $title, Renderer $renderer): void {
		$excel = new ilExcel();

		$excel->addSheet($title);

		$current_row = 1;
		$current_col = 0;

		foreach ($columns as $current_col => $column) {
			$excel->setCell($current_row, $current_col, $column);
		}
		$excel->setBold("A" . $current_row . ":" . $excel->getColumnCoord($current_col) . $current_row);
		$current_row ++;

		foreach ($rows as $row) {
			foreach ($row as $current_col => $column) {
				$excel->setCell($current_row, $current_col, $column);
			}
			$current_row ++;
		}

		$excel->sendToClient($title);
	}
}
