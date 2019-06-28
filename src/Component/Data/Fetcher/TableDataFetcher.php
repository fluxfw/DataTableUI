<?php

namespace ILIAS\UI\DataTable\Component\Data\Fetcher;

use ILIAS\UI\DataTable\Component\Data\TableData;
use ILIAS\UI\DataTable\Component\Factory\Factory;
use ILIAS\UI\DataTable\Component\Filter\TableFilter;

/**
 * Interface TableDataFetcher
 *
 * @package ILIAS\UI\DataTable\Component\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableDataFetcher {

	/**
	 * TableDataFetcher constructor
	 *
	 * @param Factory $factory
	 */
	public function __construct(Factory $factory);


	/**
	 * @param TableFilter $filter
	 *
	 * @return TableData
	 */
	public function fetchData(TableFilter $filter): TableData;
}
