<?php

namespace srag\TableUI\Component\Data\Row;

/**
 * Interface TableRowData
 *
 * @package srag\TableUI\Component\Data\Row
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableRowData {

	/**
	 * @return object
	 */
	public function getOriginalData(): object;


	/**
	 * @param object $original_data
	 *
	 * @return self
	 */
	public function withOriginalData(object $original_data): self;
}
