<?php

namespace srag\DataTable\Example\Column\Formater;

use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Implementation\Export\Formater\AbstractColumnFormater;

/**
 * Class SimplePropertyColumnFormater
 *
 * @package srag\DataTable\Example\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimplePropertyColumnFormater extends AbstractColumnFormater {

	/**
	 * @inheritDoc
	 */
	public function formatHeader(Column $column, string $table_id, Renderer $renderer): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(Column $column, RowData $row, string $table_id, Renderer $renderer): string {
		$value = $row->getOriginalData()->{$column->getKey()};

		return strval($value);
	}
}
