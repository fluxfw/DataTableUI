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
	 * @var mixed[]
	 */
	protected $field_values = [];
	/**
	 * @var string
	 */
	protected $sort_field = "";
	/**
	 * @var string
	 */
	protected $sort_field_direction = "";
	/**
	 * @var int
	 */
	protected $limit_start = 0;
	/**
	 * @var int
	 */
	protected $limit_end = 0;
	/**
	 * @var string[]
	 */
	protected $selected_columns = [];


	/**
	 * TableFilter constructor
	 */
	public function __construct() {

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
	public function getSortFieldDirection(): string {
		return $this->sort_field_direction;
	}


	/**
	 * @inheritDoc
	 */
	public function withSortFieldDirection(string $sort_field_direction): TableFilterInterface {
		$clone = clone $this;

		$clone->sort_field_direction = $sort_field_direction;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getLimitStart(): int {
		return $this->limit_start;
	}


	/**
	 * @inheritDoc
	 */
	public function withLimitStart(int $limit_start): TableFilterInterface {
		$clone = clone $this;

		$clone->limit_start = $limit_start;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getLimitEnd(): int {
		return $this->limit_end;
	}


	/**
	 * @inheritDoc
	 */
	public function withLimitEnd(int $limit_end): TableFilterInterface {
		$clone = clone $this;

		$clone->limit_end = $limit_end;

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
}
