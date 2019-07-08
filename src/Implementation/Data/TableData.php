<?php

namespace srag\DataTable\Implementation\Data;

use srag\DataTable\Component\Data\Row\TableRowData;
use srag\DataTable\Component\Data\TableData as TableDataInterface;

/**
 * Class TableData
 *
 * @package srag\DataTable\Implementation\Data
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
	 * @inheritDoc
	 */
	public function __construct(array $data, int $max_count) {
		$this->data = $data;

		$this->max_count = $max_count;
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


	/**
	 * @inheritDoc
	 */
	public function getDataCount(): int {
		return count($this->data);
	}
}
