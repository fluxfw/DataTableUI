<?php

namespace srag\DataTable\Utils;

use srag\DataTable\Component\Factory as FactoryInterface;
use srag\DataTable\Implementation\Factory;

/**
 * Trait DataTableTrait
 *
 * @package srag\DataTable\Utils
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait DataTableTrait
{

    /**
     * @return FactoryInterface
     */
    protected static function dataTable() : FactoryInterface
    {
        return Factory::getInstance();
    }
}
