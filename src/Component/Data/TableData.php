<?php

namespace srag\TableUI\Component\Data;

use srag\TableUI\Component\Data\Row\TableRowData;

/**
 * Interface TableData
 *
 * @package srag\TableUI\Component\Data
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableData {

	/**
	 * @return TableRowData[]
	 */
	public function getData(): array;


	/**
	 * @param TableRowData[] $data
	 *
	 * @return self
	 */
	public function withData(array $data): self;


	/**
	 * @return int
	 */
	public function getMaxCount(): int;


	/**
	 * @param int $max_count
	 *
	 * @return self
	 */
	public function withMaxCount(int $max_count): self;
}
