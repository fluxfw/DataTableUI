<?php

namespace srag\TableUI\Implementation\Filter\Storage;

use ilTablePropertiesStorage;
use srag\TableUI\Component\Filter\Storage\TableFilterStorage as TableFilterStorageInterface;
use srag\TableUI\Component\Filter\TableFilter as TableFilterInterface;
use srag\TableUI\Implementation\Filter\TableFilter;

/**
 * Class TableFilterStorage
 *
 * @package srag\TableUI\Implementation\Filter\Storage
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TableFilterStorage implements TableFilterStorageInterface {

	/**
	 * @var ilTablePropertiesStorage
	 */
	protected $properties_storage;


	/**
	 * @inheritDoc
	 */
	public function __construct() {
		// TODO: Not use ilTablePropertiesStorage and reimplement it - Currently just a fast solution to save the table filter
		$this->properties_storage = new ilTablePropertiesStorage();
		$this->properties_storage->properties = array_reduce(TableFilter::VARS, function (array $properties, string $property): array {
			$properties[$property] = [ "storage" => "db" ];

			return $properties;
		}, []);
	}


	/**
	 * @inheritDoc
	 */
	public function read(string $table_id, int $user_id): TableFilterInterface {
		$filter = new TableFilter($table_id, $user_id);

		foreach (TableFilter::VARS as $property) {
			$value = $this->properties_storage->getProperty($filter->getTableId(), $filter->getUserId(), $property);
			if (!empty($value)) {
				if (method_exists($filter, $method = "with" . $this->strToCamelCase($property))) {
					$filter = $filter->{$method}($value);
				}
			}
		}

		return $filter;
	}


	/**
	 * @inheritDoc
	 */
	public function store(TableFilterInterface $filter): void {
		foreach (TableFilter::VARS as $property) {
			$value = "";
			if (method_exists($filter, $method = "get" . $this->strToCamelCase($property))) {
				$value = $filter->{$method}();
			} else {
				if (method_exists($filter, $method = "is" . $this->strToCamelCase($property))) {
					$value = $filter->{$method}();
				}
			}
			$this->properties_storage->storeProperty($filter->getTableId(), $filter->getUserId(), $property, $value);
		}
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
