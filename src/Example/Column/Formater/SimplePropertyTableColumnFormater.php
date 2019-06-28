<?php

namespace ILIAS\UI\Example\Table\Data\Column\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\Component\Table\Data\Column\Formater\TableColumnFormater;
use ILIAS\UI\Component\Table\Data\Column\TableColumn;
use ILIAS\UI\Component\Table\Data\Data\Row\TableRowData;
use ILIAS\UI\Renderer;

/**
 * Class SimplePropertyTableColumnFormater
 *
 * @package ILIAS\UI\Example\Table\Data\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimplePropertyTableColumnFormater implements TableColumnFormater {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableColumn $column, Renderer $renderer, Container $dic): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(TableColumn $column, TableRowData $row, Renderer $renderer, Container $dic): string {
		$value = $row->getOriginalData()->{$column->getKey()};

		return strval($value);
	}
}
