<?php

namespace srag\DataTable\Example\Column\Formater;

use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\TableColumn;
use srag\DataTable\Component\Data\Row\TableRowData;
use srag\DataTable\Implementation\Export\Formater\AbstractTableColumnFormater;

/**
 * Class SimpleGetterTableColumnFormater
 *
 * @package srag\DataTable\Example\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimpleGetterTableColumnFormater extends AbstractTableColumnFormater {

	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableColumn $column, string $table_id, Renderer $renderer): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(TableColumn $column, TableRowData $row, string $table_id, Renderer $renderer): string {
		$value = "";

		if (method_exists($row->getOriginalData(), $method = "get" . $this->strToCamelCase($column->getKey()))) {
			$value = $row->getOriginalData()->{$method}();
		}

		if (method_exists($row->getOriginalData(), $method = "is" . $this->strToCamelCase($column->getKey()))) {
			$value = $row->getOriginalData()->{$method}();
		}

		return strval($value);
	}
}
