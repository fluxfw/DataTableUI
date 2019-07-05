<?php

namespace ILIAS\UI\Example\Table\Data\Column\Formater;

use ILIAS\UI\Component\Table\Data\Column\TableColumn;
use ILIAS\UI\Component\Table\Data\Data\Row\TableRowData;
use ILIAS\UI\Component\Table\Data\Export\TableExportFormat;
use ILIAS\UI\Implementation\Table\Data\Export\Formater\AbstractTableExportFormater;
use ILIAS\UI\Renderer;
use Throwable;

/**
 * Class SimplePropertyTableExportFormater
 *
 * @package ILIAS\UI\Example\Table\Data\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SimplePropertyTableExportFormater extends AbstractTableExportFormater {

	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableExportFormat $export_format, TableColumn $column, Renderer $renderer): string {
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
	public function formatRow(TableExportFormat $export_format, TableColumn $column, TableRowData $row, Renderer $renderer): string {
		$value = "";

		switch ($export_format->getId()) {
			default:
				try {
					$value = strval($row->getOriginalData()->{$column->getKey()});
				} catch (Throwable $ex) {
					$value = "";
				}
				break;
		}

		return strval($value);
	}
}
