<?php

namespace srag\TableUI\Implementation\Export;

use ILIAS\UI\NotImplementedException;
use srag\TableUI\Component\Export\TableExportFormat;

/**
 * Class TableCSVExportFormat
 *
 * @package srag\TableUI\Implementation\Export
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
	public function export(array $columns, array $rows): void {
		// TODO:
		throw new NotImplementedException("CSV export not implemented yet!");
	}
}
