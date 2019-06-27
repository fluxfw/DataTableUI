<?php

namespace srag\TableUI\Implementation\Export;

use ilExcel;
use srag\TableUI\Component\Export\TableExportFormat;

/**
 * Class TableExcelExportFormat
 *
 * @package srag\TableUI\Implementation\Export
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TableExcelExportFormat implements TableExportFormat {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


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
		return "Excel";
	}


	/**
	 * @inheritDoc
	 */
	public function export(array $columns, array $rows, string $title): void {
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
