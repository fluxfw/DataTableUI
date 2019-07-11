<?php

namespace srag\DataTable\Component\Column\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;

/**
 * Interface ColumnFormater
 *
 * @package srag\DataTable\Component\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface ColumnFormater {

	/**
	 * ColumnFormater constructor
	 *
	 * @param Container $dic
	 */
	public function __construct(Container $dic);


	/**
	 * @param Column   $column
	 * @param string   $table_id
	 * @param Renderer $renderer
	 *
	 * @return string
	 */
	public function formatHeader(Column $column, string $table_id, Renderer $renderer): string;


	/**
	 * @param Column   $column
	 * @param RowData  $row
	 * @param string   $table_id
	 * @param Renderer $renderer
	 *
	 * @return string
	 */
	public function formatRow(Column $column, RowData $row, string $table_id, Renderer $renderer): string;
}
