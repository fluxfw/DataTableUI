<?php

namespace srag\TableUI\Implementation\Export;

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
	 * TablePDFExportFormat constructor
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
	public function export(): void {
		// TODO: Implement export() method.
	}
}
