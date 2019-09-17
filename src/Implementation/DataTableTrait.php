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
trait DataTableTrait
{

    /**
     * ---
     * description:
     *   purpose: TODO
     *   composition: TODO
     *   rivals:
     *     Rival 1: TODO
     *
     * rules:
     *   usage:
     *     1: TODO
     *     2: TODO
     *     3: TODO
     *     4: TODO
     *     5: TODO
     *     6: TODO
     *   responsiveness:
     *     7: TODO
     *
     * ---
     *
     * @return FactoryInterface|FactoryInterfaceCore
     */
    protected static final function datatable()
    {
        if (self::version()->is60()) {
            return self::dic()->ui()->factory()->table()->data(self::dic()->dic());
        } else {
            return new Factory(self::dic()->dic());
        }
    }
}
