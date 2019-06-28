<?php

namespace ILIAS\UI\DataTable\Implementation\Export;

use GuzzleHttp\Psr7\Stream;
use ilCSVWriter;
use ILIAS\DI\Container;
use ILIAS\UI\DataTable\Component\Export\TableExportFormat;
use ILIAS\UI\Renderer;
use ilMimeTypeUtil;

/**
 * Class TableCSVExportFormat
 *
 * @package ILIAS\UI\DataTable\Implementation\Export
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TableCSVExportFormat implements TableExportFormat {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function getId(): int {
		return self::EXPORT_FORMAT_CSV;
	}


	/**
	 * @inheritDoc
	 */
	public function getTitle(): string {
		return "CSV";
	}


	/**
	 * @inheritDoc
	 */
	public function export(array $columns, array $rows, string $title, Renderer $renderer, Container $dic): void {
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

		// TODO: Some unneeded code!!!

		$filename = $title . ".csv";

		$stream = new Stream(fopen("php://memory", "rw"));
		$stream->write($data);

		$dic->http()->saveResponse(self::dic()->http()->response()->withBody($stream)->withHeader("Content-Disposition", 'attachment; filename="'
			. $filename . '"')// Filename
		->withHeader("Content-Type", ilMimeTypeUtil::APPLICATION__OCTET_STREAM)// Force download
		->withHeader("Expires", "0")->withHeader("Pragma", "public")); // No cache

		$dic->http()->sendResponse();

		exit;
	}
}
