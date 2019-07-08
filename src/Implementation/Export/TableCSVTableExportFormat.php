<?php

namespace srag\DataTable\Implementation\Export;

use GuzzleHttp\Psr7\Stream;
use ilCSVWriter;
use ILIAS\UI\Renderer;
use ilMimeTypeUtil;
use srag\DataTable\Component\DataTable;

/**
 * Class TableCSVExportFormat
 *
 * @package srag\DataTable\Implementation\Export
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TableCSVTableExportFormat extends AbstractTableExportFormat {

	/**
	 * @inheritDoc
	 */
	public function getExportId(): string {
		return self::EXPORT_FORMAT_CSV;
	}


	/**
	 * @inheritDoc
	 */
	public function getTitle(): string {
		return $this->dic->language()->txt(DataTable::LANG_MODULE . "_export_csv");
	}


	/**
	 * @inheritDoc
	 */
	public function export(array $columns, array $rows, string $title, string $table_id, Renderer $renderer): void {
		$csv = new ilCSVWriter();

		$csv->setSeparator(";");

		foreach ($columns as $column) {
			$csv->addColumn($column);
		}
		$csv->addRow();

		foreach ($rows as $row) {
			foreach ($row as $column) {
				$csv->addColumn($column);
			}
			$csv->addRow();
		}

		$data = $csv->getCSVString();

		// TODO: Some unneeded code ?!

		$filename = $title . ".csv";

		$stream = new Stream(fopen("php://memory", "rw"));
		$stream->write($data);

		$this->dic->http()->saveResponse($this->dic->http()->response()->withBody($stream)->withHeader("Content-Disposition", 'attachment; filename="'
			. $filename . '"')// Filename
		->withHeader("Content-Type", ilMimeTypeUtil::APPLICATION__OCTET_STREAM)// Force download
		->withHeader("Expires", "0")->withHeader("Pragma", "public"));// No cache

		$this->dic->http()->sendResponse();

		exit;
	}
}
