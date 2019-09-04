<?php

namespace srag\DataTable\Implementation\Data\Fetcher;

use ILIAS\DI\Container;
use srag\DataTable\Component\Data\Data as DataInterface;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Table;
use srag\DataTable\Implementation\Data\Data;
use srag\DataTable\Implementation\Data\Row\GetterRowData;
use srag\DataTable\Implementation\Data\Row\PropertyRowData;

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
	public function getNoDataText(Table $component): string {
		return $component->getPlugin()->translate("no_data", Table::LANG_MODULE);
	}


	/**
	 * @inheritDoc
	 */
	public function isFetchDataNeedsFilterFirstSet(): bool {
		return false;
	}


	/**
	 * @inheritDoc
	 */
	public function data(array $data, int $max_count): DataInterface {
		return new Data($data, $max_count);
	}


	/**
	 * @inheritDoc
	 */
	public function propertyRowData(string $row_id, object $original_data): RowData {
		return new PropertyRowData($row_id, $original_data);
	}


	/**
	 * @inheritDoc
	 */
	public function getterRowData(string $row_id, object $original_data): RowData {
		return new GetterRowData($row_id, $original_data);
	}
}
