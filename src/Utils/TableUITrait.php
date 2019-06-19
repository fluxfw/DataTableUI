<?php

namespace srag\TableUI\Utils;

use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Fetcher\TableDataFetcher;
use srag\TableUI\Component\TableUI as TableUIInterface;
use srag\TableUI\Implementation\TableUI;

/**
 * Trait TableUITrait
 *
 * @package srag\TableUI\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait TableUITrait {

	/**
	 * @param string           $id
	 * @param string           $action_url
	 * @param string           $action_cmd
	 * @param string           $title
	 * @param TableColumn[]    $columns
	 * @param TableDataFetcher $data_fetcher
	 *
	 * @return TableUIInterface
	 */
	protected static function tableui(string $id, string $action_url, string $action_cmd, string $title, array $columns, TableDataFetcher $data_fetcher): TableUIInterface {
		return new TableUI($id, $action_url, $action_cmd, $title, $columns, $data_fetcher);
	}
}
