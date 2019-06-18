<?php

namespace srag\TableUI\Component\Column\Formater;

use srag\TableUI\Component\Data\Row\TableRowData;

/**
 * Interface TableColumnFormater
 *
 * @package srag\TableUI\Component\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableColumnFormater {

	/**
	 * @param TableRowData $row
	 *
	 * @return string
	 */
	public function format(TableRowData $row): string;
}
