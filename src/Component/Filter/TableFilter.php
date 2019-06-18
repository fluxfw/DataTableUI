<?php

namespace srag\TableUI\Component\Filter;

/**
 * Interface TableFilter
 *
 * @package srag\TableUI\Component\Filter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableFilter {

	/**
	 * @var int
	 */
	const FILTER_TOP = 1;
	/**
	 * @var int
	 */
	const FILTER_BOTTOM = 2;


	/**
	 * @param string $key
	 *
	 * @return int
	 */
	public function getFieldValueAsInteger(string $key): int;


	/**
	 * @param string $key
	 *
	 * @return string
	 */
	public function getFieldValueAsString(string $key): string;


	/**
	 * @param mixed[] $field_values
	 *
	 * @return self
	 */
	public function withFieldValues(array $field_values): self;


	/**
	 * @return string
	 */
	public function getSortField(): string;


	/**
	 * @param string $sort_field
	 *
	 * @return self
	 */
	public function withSortField(string $sort_field): self;


	/**
	 * @return string
	 */
	public function getSortFieldDirection(): string;


	/**
	 * @param string $sort_field_direction
	 *
	 * @return self
	 */
	public function withSortFieldDirection(string $sort_field_direction): self;


	/**
	 * @return int
	 */
	public function getLimitStart(): int;


	/**
	 * @param int $limit_start
	 *
	 * @return self
	 */
	public function withLimitStart(int $limit_start): self;


	/**
	 * @return int
	 */
	public function getLimitEnd(): int;


	/**
	 * @param int $limit_end
	 *
	 * @return self
	 */
	public function withLimitEnd(int $limit_end): self;


	/**
	 * @return string[]
	 */
	public function getSelectedColumns(): array;


	/**
	 * @param string[] $selected_columns
	 *
	 * @return self
	 */
	public function withSelectedColumns(array $selected_columns): self;
}
