<?php

namespace srag\DataTable\Component\Data\Fetcher;

use ILIAS\DI\Container;
use srag\DataTable\Component\Data\TableData;
use srag\DataTable\Component\Factory\Factory;
use srag\DataTable\Component\Filter\TableFilter;

/**
 * Interface TableDataFetcher
 *
 * @package srag\DataTable\Component\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableDataFetcher {

	/**
	 * TableDataFetcher constructor
	 *
	 * @param Container $dic
	 */
	public function __construct(Container $dic);


	/**
	 * @param TableFilter $filter
	 * @param Factory     $factory
	 *
	 * @return TableData
	 */
	public function fetchData(TableFilter $filter, Factory $factory): TableData;
}
