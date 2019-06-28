<?php

namespace ILIAS\UI\Example\Table\Data\Data\Fetcher;

use ILIAS\UI\Component\Table\Data\Data\Fetcher\TableDataFetcher;
use ILIAS\UI\Component\Table\Data\Data\Row\TableRowData;
use ILIAS\UI\Component\Table\Data\Data\TableData;
use ILIAS\UI\Component\Table\Data\Factory\Factory;
use ILIAS\UI\Component\Table\Data\Filter\Sort\TableFilterSortField;
use ILIAS\UI\Component\Table\Data\Filter\TableFilter;
use stdClass;

/**
 * Class StaticArrayTableDataFetcher
 *
 * @package ILIAS\UI\Example\Table\Data\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class StaticArrayTableDataFetcher implements TableDataFetcher {

	/**
	 * @var stdClass[]
	 */
	protected $data = [];


	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @return stdClass[]
	 */
	public function getData(): array {
		return $this->data;
	}


	/**
	 * @param stdClass[] $data
	 *
	 * @return self
	 */
	public function withData(array $data): self {
		$clone = clone $this;

		$clone->data = $data;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function fetchData(TableFilter $filter, Factory $factory): TableData {
		$data = $this->data;

		$data = array_filter($data, function (stdClass $data) use ($filter): bool {
			$match = true;

			foreach ($filter->getFieldValues() as $key => $value) {
				if (!empty($value)) {
					switch (true) {
						case is_array($value):
							$match = in_array($data->{$key}, $value);
							break;

						case is_integer($data->{$key}):
						case is_float($data->{$key}):
							$match = ($data->{$key} === intval($value));
							break;

						case is_string($data->{$key}):
							$match = (stripos($data->{$key}, $value) !== false);
							break;

						default:
							$match = ($data->{$key} === $value);
							break;
					}

					if (!$match) {
						break;
					}
				}
			}

			return $match;
		});

		usort($data, function (stdClass $o1, stdClass $o2) use ($filter): int {
			foreach ($filter->getSortFields() as $sort_field) {
				$s1 = strval($o1->{$sort_field->getSortField()});
				$s2 = strval($o2->{$sort_field->getSortField()});

				$i = strnatcmp($s1, $s2);

				if ($sort_field->getSortFieldDirection() === TableFilterSortField::SORT_DIRECTION_DOWN) {
					$i *= - 1;
				}

				if ($i !== 0) {
					return $i;
				}
			}

			return 0;
		});

		$max_count = count($data);

		$data = array_slice($data, $filter->getLimitStart(), $filter->getLimitEnd());

		$data = array_map(function (stdClass $row): TableRowData {
			return $this->factory->rowData($row->column1, $row);
		}, $data);

		return $this->factory->data($data, $max_count);
	}
}
