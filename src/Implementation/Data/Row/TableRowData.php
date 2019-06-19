<?php

namespace srag\TableUI\Implementation\Data\Row;

use srag\TableUI\Component\Data\Row\TableRowData as TableRowDataInterface;

/**
 * Class TableRowData
 *
 * @package srag\TableUI\Implementation\Data\Row
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TableRowData implements TableRowDataInterface {

	/**
	 * @var object
	 */
	protected $original_data;


	/**
	 * @inheritDoc
	 */
	public function __construct(object $original_data) {
		$this->original_data = $original_data;
	}


	/**
	 * @inheritDoc
	 */
	public function getOriginalData(): object {
		return $this->original_data;
	}


	/**
	 * @inheritDoc
	 */
	public function withOriginalData(object $original_data): TableRowDataInterface {
		$clone = clone $this;

		$clone->original_data = $original_data;

		return $clone;
	}
}
