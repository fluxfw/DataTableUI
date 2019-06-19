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
	 * @var int
	 */
	const EXPORT_FORMAT_CSV = 1;
	/**
	 * @var int
	 */
	const EXPORT_FORMAT_EXCEL = 2;
	/**
	 * @var int
	 */
	const EXPORT_FORMAT_PDF = 3;


	/**
	 * @return int
	 */
	public function getId(): int;


	/**
	 * @return string
	 */
	public function getTitle(): string;


	/**
	 *
	 */
	public function export(): void;
}
