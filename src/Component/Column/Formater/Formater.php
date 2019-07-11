<?php

namespace srag\DataTable\Component\Column\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;

/**
 * Interface Formater
 *
 * @package srag\DataTable\Component\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Formater {

	/**
	 * Formater constructor
	 *
	 * @param Container $dic
	 */
	public function __construct(Container $dic);


	/**
	 * @param string   $format_id
	 * @param Column   $column
	 * @param string   $table_id
	 * @param Renderer $renderer
	 *
	 * @return string
	 */
	public function formatHeader(string $format_id, Column $column, string $table_id, Renderer $renderer): string;


	/**
	 * @param string   $format_id
	 * @param Column   $column
	 * @param RowData  $row
	 * @param string   $table_id
	 * @param Renderer $renderer
	 *
	 * @return string
	 */
	public function formatRow(string $format_id, Column $column, RowData $row, string $table_id, Renderer $renderer): string;
}