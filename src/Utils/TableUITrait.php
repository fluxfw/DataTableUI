<?php

namespace srag\TableUI\Utils;

use srag\TableUI\Component\Factory as FactoryInterface;
use srag\TableUI\Implementation\Factory;

/**
 * Trait TableUITrait
 *
 * @package srag\TableUI\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait TableUITrait {

	/**
	 * @return FactoryInterface
	 */
	protected static function tableui(): FactoryInterface {
		return new Factory();
	}
}
