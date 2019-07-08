<?php

namespace srag\DataTable\Implementation\Data\Fetcher;

use ILIAS\DI\Container;
use srag\DataTable\Component\Data\Fetcher\TableDataFetcher;

/**
 * Class AbstractTableDataFetcher
 *
 * @package srag\DataTable\Implementation\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractTableDataFetcher implements TableDataFetcher {

	/**
	 * @var Container
	 */
	protected $dic;


	/**
	 * @inheritDoc
	 */
	public function __construct(Container $dic) {
		$this->dic = $dic;
	}
}
