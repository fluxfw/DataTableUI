<?php

namespace ILIAS\UI\Example\Table\Data\Column\Formater;

use ILIAS\UI\Component\Table\Data\Column\TableColumn;
use ILIAS\UI\Component\Table\Data\Data\Row\TableRowData;
use ILIAS\UI\Implementation\Table\Data\Export\Formater\AbstractTableColumnFormater;
use ILIAS\UI\Renderer;

/**
 * Class SimplePropertyTableColumnFormater
 *
 * @package ILIAS\UI\Example\Table\Data\Column\Formater
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
