<?php

namespace srag\DataTable\Implementation\Filter\Storage;

use srag\DataTable\Component\Filter\Filter as FilterInterface;
use srag\DataTable\Component\Filter\Sort\FilterSortField as FilterSortFieldInterface;
use srag\DataTable\Component\Filter\Storage\FilterStorage;
use srag\DataTable\Implementation\Filter\Filter;
use srag\DataTable\Implementation\Filter\Sort\FilterSortField;

/**
 * Class AbstractFilterStorage
 *
 * @package srag\DataTable\Implementation\Filter\Storage
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractFilterStorage implements FilterStorage {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function filter(string $table_id, int $user_id): FilterInterface {
		return new Filter($table_id, $user_id);
	}


	/**
	 * @inheritDoc
	 */
	public function sortField(string $sort_field, int $sort_field_direction): FilterSortFieldInterface {
		return new FilterSortField($sort_field, $sort_field_direction);
	}


	/**
	 * @param string $string
	 *
	 * @return string
	 */
	protected function strToCamelCase(string $string): string {
		return str_replace("_", "", ucwords($string, "_"));
	}
}
