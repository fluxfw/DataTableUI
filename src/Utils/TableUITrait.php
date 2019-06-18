<?php

namespace srag\TableUI\Utils;

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
	 * @return TableUIInterface
	 */
	protected static function tableui(): TableUIInterface {
		return new TableUI();
	}
}
