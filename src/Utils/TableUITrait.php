<?php

namespace ILIAS\UI\DataTable\Utils;

use ILIAS\UI\DataTable\Component\Factory\Factory as FactoryInterface;
use ILIAS\UI\DataTable\Implementation\Factory\Factory;

/**
 * Trait TableUITrait
 *
 * @package ILIAS\UI\DataTable\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait TableUITrait {

	/**
	 * @return FactoryInterface
	 */
	protected static function datatable(): FactoryInterface {
		return new Factory();
	}
}
