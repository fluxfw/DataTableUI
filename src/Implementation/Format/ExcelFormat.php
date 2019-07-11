<?php

namespace srag\DataTable\Implementation\Format;

use ilExcel;
use ILIAS\UI\Renderer;

/**
 * Class ExcelFormat
 *
 * @package srag\DataTable\Implementation\Format
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ExcelFormat extends AbstractFormat {

	/**
	 * @inheritDoc
	 */
	public function getFormatId(): string {
		return self::FORMAT_EXCEL;
	}


	/**
	 * @inheritDoc
	 */
	public function getFileExtension(): string {
		return "xlsx";
	}


	/**
	 * @inheritDoc
	 */
	public function render(array $columns, array $rows, string $title, string $table_id, Renderer $renderer): string {
		$excel = new ilExcel();

		$excel->addSheet($title);

		$current_row = 1;
		$current_col = 1;

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

		$tmp_file = $excel->writeToTmpFile();

		$data = file_get_contents($tmp_file);

		unlink($tmp_file);

		return $data;
	}
}