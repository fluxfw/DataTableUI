<?php

namespace srag\DataTable\Component\Data;

use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Data\Row\RowDataGetter;

/**
 * Interface Data
 *
 * @package srag\DataTable\Component\Data
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Data {

	/**
	 * Data constructor
	 *
	 * @param RowData[] $data
	 * @param int       $max_count
	 */
	public function __construct(array $data, int $max_count);


	/**
	 * @return RowData[]
	 */
	public function getData(): array;


	/**
	 * @param RowData[] $data
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


	/**
	 * @return int
	 */
	public function getDataCount(): int;
}
