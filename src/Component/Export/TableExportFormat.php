<?php

namespace srag\TableUI\Component\Export;

/**
 * Interface TableExportFormat
 *
 * @package srag\TableUI\Component\Export
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableExportFormat {

	/**
	 * @return string
	 */
	public function getTitle(): string;


	/**
	 *
	 */
	public function export(): void;
}
