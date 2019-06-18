<?php

namespace srag\TableUI\Component\Data\Fetcher;

use srag\TableUI\Component\Data\TableData;
use srag\TableUI\Component\Filter\TableFilter;

/**
 * Interface TableDataFetcher
 *
 * @package srag\TableUI\Component\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableDataFetcher {

	/**
	 * @param TableFilter $filter
	 *
	 * @return TableData
	 */
	public function fetchData(TableFilter $filter): TableData;
}
