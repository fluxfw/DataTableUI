<?php

namespace ILIAS\UI\DataTable\Implementation\Export;

use ILIAS\DI\Container;
use ILIAS\UI\DataTable\Component\Export\TableExportFormat;
use ILIAS\UI\NotImplementedException;
use ILIAS\UI\Renderer;

/**
 * Class TablePDFExportFormat
 *
 * @package ILIAS\UI\DataTable\Implementation\Export
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
	public function export(array $columns, array $rows, string $title, Renderer $renderer, Container $dic): void {
		// TODO:
		throw new NotImplementedException("PDF export not implemented yet!");
	}
}
