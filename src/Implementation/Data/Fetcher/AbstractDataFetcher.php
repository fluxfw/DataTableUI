<?php

namespace srag\DataTable\Implementation\Data\Fetcher;

use ILIAS\DI\Container;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Table;

/**
 * Class AbstractDataFetcher
 *
 * @package srag\DataTable\Implementation\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractDataFetcher implements DataFetcher {

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


	/**
	 * @inheritDoc
	 */
	public function getNoDataText(): string {
		return $this->dic->language()->txt(Table::LANG_MODULE . "_no_data");
	}
}
