<?php

namespace srag\TableUI\Component\Export\Formater;

use srag\TableUI\Component\Data\Row\TableRowData;

/**
 * Interface TableExportFormater
 *
 * @package srag\TableUI\Component\Export\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableExportFormater {

	/**
	 * @param TableRowData $row
	 *
	 * @return string
	 */
	public function format(TableRowData $row, string $export_format): string;
}
