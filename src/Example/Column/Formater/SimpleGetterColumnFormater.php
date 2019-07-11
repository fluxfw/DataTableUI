<?php

namespace srag\DataTable\Example\Column\Formater;

use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Implementation\Export\Formater\AbstractColumnFormater;

/**
 * Class SimpleGetterColumnFormater
 *
 * @package srag\DataTable\Example\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimpleGetterColumnFormater extends AbstractColumnFormater {

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
