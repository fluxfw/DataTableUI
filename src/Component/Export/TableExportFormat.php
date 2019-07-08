<?php

namespace srag\DataTable\Component\Export;

use ILIAS\DI\Container;
use ILIAS\UI\Renderer;

/**
 * Interface TableExportFormat
 *
 * @package srag\DataTable\Component\Export
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
	 * TableExportFormat constructor
	 *
	 * @param Container $dic
	 */
	public function __construct(Container $dic);


	/**
	 * @return int
	 */
	public function getId(): int;


	/**
	 * @return string
	 */
	public function getTitle(): string;


	/**
	 * @param string[] $columns
	 * @param array    $rows
	 * @param string   $title
	 * @param Renderer $renderer
	 */
	public function export(array $columns, array $rows, string $title, Renderer $renderer): void;
}
