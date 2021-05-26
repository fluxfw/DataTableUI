<?php

namespace srag\DataTableUI\Implementation\Utils;

use srag\DataTableUI\Component\Factory as FactoryInterface;
use srag\DataTableUI\Implementation\Factory;

/**
 * Trait DataTableUITrait
 *
 * @package srag\DataTableUI\Implementation\Utils
 */
trait DataTableUITrait
{

    /**
     * @return FactoryInterface
     */
    protected static function dataTableUI() : FactoryInterface
    {
        return Factory::getInstance();
    }
}
