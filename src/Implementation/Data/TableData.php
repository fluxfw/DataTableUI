<?php

namespace srag\TableUI\Implementation\Data;

use srag\TableUI\Component\Data\Row\TableRowData;
use srag\TableUI\Component\Data\TableData as TableDataInterface;

/**
 * Class TableData
 *
 * @package srag\TableUI\Implementation\Data
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TableData implements TableDataInterface {

	/**
	 * @var TableRowData[]
	 */
	protected $data = [];
	/**
	 * @var int
	 */
	protected $max_count = 0;


	/**
	 * TableData constructor
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function getData(): array {
		return $this->data;
	}


	/**
	 * @inheritDoc
	 */
	public function withData(array $data): TableDataInterface {
		$clone = clone $this;

		$clone->data = $data;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getMaxCount(): int {
		return $this->max_count;
	}


	/**
	 * @inheritDoc
	 */
	public function withMaxCount(int $max_count): TableDataInterface {
		$clone = clone $this;

		$clone->max_count = $max_count;

		return $clone;
	}
}
