<?php

namespace srag\DataTable\Example\Column\Formater;

use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\TableColumn;
use srag\DataTable\Component\Data\Row\TableRowData;
use srag\DataTable\Implementation\Export\Formater\AbstractTableColumnFormater;

/**
 * Class SimplePropertyTableColumnFormater
 *
 * @package srag\DataTable\Example\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimplePropertyTableColumnFormater extends AbstractTableColumnFormater {

	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableColumn $column, Renderer $renderer): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(TableColumn $column, TableRowData $row, Renderer $renderer): string {
		$value = $row->getOriginalData()->{$column->getKey()};

		return strval($value);
	}
}
