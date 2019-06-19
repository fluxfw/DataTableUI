<?php

namespace srag\TableUI\Implementation\Filter;

use srag\TableUI\Component\Filter\TableFilter as TableFilterInterface;

/**
 * Class TableFilter
 *
 * @package srag\TableUI\Implementation\Filter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TableFilter implements TableFilterInterface {

	/**
	 * @var string
	 */
	protected $table_id = "";
	/**
	 * @var int
	 */
	protected $user_id = 0;
	/**
	 * @var mixed[]
	 */
	protected $field_values = [];
	/**
	 * @var string
	 */
	protected $sort_field = "";
	/**
	 * @var int
	 */
	protected $sort_field_direction = 0;
	/**
	 * @var string[]
	 */
	protected $selected_columns = [];
	/**
	 * @var bool
	 */
	protected $filter_set = false;
	/**
	 * @var int
	 */
	protected $rows_count = self::DEFAULT_ROWS_COUNT;
	/**
	 * @var int
	 */
	protected $current_page = 1;


	/**
	 * @inheritDoc
	 */
	public function __construct(string $table_id, int $user_id) {
		$this->table_id = $table_id;

		$this->user_id = $user_id;
	}


	/**
	 * @inheritDoc
	 */
	public function getTableId(): string {
		return $this->table_id;
	}


	/**
	 * @inheritDoc
	 */
	public function withTableId(string $table_id): TableFilterInterface {
		$clone = clone $this;

		$clone->table_id = $table_id;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getUserId(): int {
		return $this->user_id;
	}


	/**
	 * @inheritDoc
	 */
	public function withUserId(int $user_id): TableFilterInterface {
		$clone = clone $this;

		$clone->user_id = $user_id;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getFieldValueAsInteger(string $key): int {
		return intval($this->field_values[$key]);
	}


	/**
	 * @inheritDoc
	 */
	public function getFieldValueAsString(string $key): string {
		return strval($this->field_values[$key]);
	}


	/**
	 * @inheritDoc
	 */
	public function withFieldValues(array $field_values): TableFilterInterface {
		$clone = clone $this;

		$clone->field_values = $field_values;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getSortField(): string {
		return $this->sort_field;
	}


	/**
	 * @inheritDoc
	 */
	public function withSortField(string $sort_field): TableFilterInterface {
		$clone = clone $this;

		$clone->sort_field = $sort_field;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getSortFieldDirection(): int {
		return $this->sort_field_direction;
	}


	/**
	 * @inheritDoc
	 */
	public function withSortFieldDirection(int $sort_field_direction): TableFilterInterface {
		$clone = clone $this;

		$clone->sort_field_direction = $sort_field_direction;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getSelectedColumns(): array {
		return $this->selected_columns;
	}


	/**
	 * @inheritDoc
	 */
	public function withSelectedColumns(array $selected_columns): TableFilterInterface {
		$clone = clone $this;

		$clone->selected_columns = $selected_columns;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function isFilterSet(): bool {
		return $this->filter_set;
	}


	/**
	 * @inheritDoc
	 */
	public function withFilterSet(bool $filter_set = false): TableFilterInterface {
		$clone = clone $this;

		$clone->filter_set = $filter_set;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getRowsCount(): int {
		return $this->rows_count;
	}


	/**
	 * @inheritDoc
	 */
	public function withRowsCount(int $rows_count = self::DEFAULT_ROWS_COUNT): TableFilterInterface {
		$clone = clone $this;

		$clone->rows_count = $rows_count;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getCurrentPage(): int {
		return $this->current_page;
	}


	/**
	 * @inheritDoc
	 */
	public function withCurrentPage(int $current_page = 1): TableFilterInterface {
		$clone = clone $this;

		$clone->current_page = $current_page;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getTotalPages(int $max_count): int {
		return ceil($max_count / $this->getRowsCount());
	}


	/**
	 * @inheritDoc
	 */
	public function getLimitStart(): int {
		return (($this->getCurrentPage() - 1) * $this->getRowsCount());
	}


	/**
	 * @inheritDoc
	 */
	public function getLimitEnd(): int {
		return ($this->getCurrentPage() * $this->getRowsCount());
	}
}
