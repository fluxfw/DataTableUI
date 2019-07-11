<?php

namespace srag\DataTable\Component\Data\Fetcher;

use ILIAS\DI\Container;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Factory\Factory;
use srag\DataTable\Component\Filter\Filter;

/**
 * Interface DataFetcher
 *
 * @package srag\DataTable\Component\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface DataFetcher {

	/**
	 * DataFetcher constructor
	 *
	 * @param Container $dic
	 */
	public function __construct(Container $dic);


	/**
	 * @param Filter  $filter
	 * @param Factory $factory
	 *
	 * @return Data
	 */
	public function fetchData(Filter $filter, Factory $factory): Data;


	/**
	 * @return string
	 */
	public function getNoDataText(): string;
}
