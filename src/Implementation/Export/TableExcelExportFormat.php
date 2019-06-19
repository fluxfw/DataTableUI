<?php

namespace srag\TableUI\Implementation\Export;

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
	public function export(): void {
		// TODO: Implement export() method.
	}
}
