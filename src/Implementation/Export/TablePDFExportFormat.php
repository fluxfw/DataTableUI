<?php

namespace srag\TableUI\Implementation\Export;

use ILIAS\UI\NotImplementedException;
use srag\TableUI\Component\Export\TableExportFormat;

/**
 * Class TablePDFExportFormat
 *
 * @package srag\TableUI\Implementation\Export
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TablePDFExportFormat implements TableExportFormat {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function getId(): int {
		return self::EXPORT_FORMAT_PDF;
	}


	/**
	 * @inheritDoc
	 */
	public function getTitle(): string {
		return "PDF";
	}


	/**
	 * @inheritDoc
	 */
	public function export(array $columns, array $rows, string $title): void {
		// TODO:
		throw new NotImplementedException("PDF export not implemented yet!");
	}
}
