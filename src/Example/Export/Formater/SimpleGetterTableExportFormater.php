<?php

namespace ILIAS\UI\Example\Table\Data\Column\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\Component\Table\Data\Column\TableColumn;
use ILIAS\UI\Component\Table\Data\Data\Row\TableRowData;
use ILIAS\UI\Component\Table\Data\Export\Formater\TableExportFormater;
use ILIAS\UI\Component\Table\Data\Export\TableExportFormat;
use ILIAS\UI\Renderer;
use Throwable;

/**
 * Class SimpleGetterTableExportFormater
 *
 * @package ILIAS\UI\Example\Table\Data\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimpleGetterTableExportFormater implements TableExportFormater {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableExportFormat $export_format, TableColumn $column, Renderer $renderer, Container $dic): string {
		$value = "";

		switch ($export_format->getId()) {
			default:
				$value = $column->getTitle();
				break;
		}

		return strval($value);
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(TableExportFormat $export_format, TableColumn $column, TableRowData $row, Renderer $renderer, Container $dic): string {
		$value = "";

		switch ($export_format->getId()) {
			default:
				try {
					if (method_exists($row->getOriginalData(), $method = "get" . $this->strToCamelCase($column->getKey()))) {
						$value = strval($row->getOriginalData()->{$method}());
					}

					if (method_exists($row->getOriginalData(), $method = "is" . $this->strToCamelCase($column->getKey()))) {
						$value = strval($row->getOriginalData()->{$method}());
					}
				} catch (Throwable $ex) {
					$value = "";
				}
				break;
		}

		return strval($value);
	}


	/**
	 * @param string $string
	 *
	 * @return string
	 */
	protected function strToCamelCase(string $string): string {
		return str_replace("_", "", ucwords($string, "_"));
	}
}
