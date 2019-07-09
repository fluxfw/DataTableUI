<?php

namespace srag\DataTable\Implementation;

use ILIAS\UI\Component\Table\Data\Factory\Factory as FactoryInterfaceCore;
use srag\DataTable\Component\Factory\Factory as FactoryInterface;
use srag\DataTable\Implementation\Factory\Factory;

/**
 * Trait DataTableTrait
 *
 * @package srag\DataTable\Implementation
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait DataTableTrait {

	/**
	 * @return FactoryInterface|FactoryInterfaceCore
	 */
	protected static final function datatable() {
		if (self::version()->is60()) {
			return self::dic()->ui()->factory()->table()->data(self::dic()->dic());
		} else {
			return new Factory(self::dic()->dic());
		}
	}
}
