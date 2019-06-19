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
	 * @var int
	 */
	const SORT_DIRECTION_UP = 1;
	/**
	 * @var int
	 */
	const SORT_DIRECTION_DOWN = 2;
	/**
	 * @var int
	 */
	const DEFAULT_ROWS_COUNT = 50;
	/**
	 * @var int[]
	 */
	const ROWS_COUNT = [
		5,
		10,
		15,
		20,
		30,
		40,
		self::DEFAULT_ROWS_COUNT,
		100,
		200,
		400,
		800
	];
	/**
	 * @var string
	 */
	const VAR_SORT_FIELD = "sort_field";
	/**
	 * @var string
	 */
	const VAR_SORT_FIELD_DIRECTION = "sort_field_direction";
	/**
	 * @var string
	 */
	const VAR_ROWS_COUNT = "rows_count";
	/**
	 * @var string
	 */
	const VAR_CURRENT_PAGE = "current_page";
	/**
	 * @var string[]
	 */
	const VARS = [
		self::VAR_SORT_FIELD,
		self::VAR_SORT_FIELD_DIRECTION,
		self::VAR_ROWS_COUNT,
		self::VAR_CURRENT_PAGE
	];


	/**
	 * TableFilter constructor
	 *
	 * @param string $table_id
	 * @param int    $user_id
	 */
	public function __construct(string $table_id, int $user_id);


	/**
	 * @return string
	 */
	public function getTableId(): string;


	/**
	 * @param string $table_id
	 *
	 * @return self
	 */
	public function withTableId(string $table_id): self;


	/**
	 * @return int
	 */
	public function getUserId(): int;


	/**
	 * @param int $user_id
	 *
	 * @return self
	 */
	public function withUserId(int $user_id): self;


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
	 * @return int
	 */
	public function getSortFieldDirection(): int;


	/**
	 * @param string $sort_field_direction
	 *
	 * @return self
	 */
	public function withSortFieldDirection(int $sort_field_direction): self;


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


	/**
	 * @return bool
	 */
	public function isFilterSet(): bool;


	/**
	 * @param bool $filter_set
	 *
	 * @return self
	 */
	public function withFilterSet(bool $filter_set = false): self;


	/**
	 * @return int
	 */
	public function getRowsCount(): int;


	/**
	 * @param int $rows_count
	 *
	 * @return self
	 */
	public function withRowsCount(int $rows_count = self::DEFAULT_ROWS_COUNT): self;


	/**
	 * @return int
	 */
	public function getCurrentPage(): int;


	/**
	 * @param int $current_page
	 *
	 * @return self
	 */
	public function withCurrentPage(int $current_page = 1): self;


	/**
	 * @param int $max_count
	 *
	 * @return int
	 */
	public function getTotalPages(int $max_count): int;


	/**
	 * @return int
	 */
	public function getLimitStart(): int;


	/**
	 * @return int
	 */
	public function getLimitEnd(): int;
}
