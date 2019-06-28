<?php

namespace ILIAS\UI\DataTable\Component\Data;

use ILIAS\UI\DataTable\Component\Data\Row\TableRowData;

/**
 * Interface TableData
 *
 * @package ILIAS\UI\DataTable\Component\Data
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableData {

	/**
	 * TableData constructor
	 *
	 * @param TableRowData[] $data
	 * @param int            $max_count
	 */
	public function __construct(array $data, int $max_count);


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


	/**
	 * @return int
	 */
	public function getDataCount(): int;
}
