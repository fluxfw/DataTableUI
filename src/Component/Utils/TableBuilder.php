<?php

namespace srag\DataTableUI\Component\Utils;

use srag\DataTableUI\Component\Table;

/**
 * Interface TableBuilder
 *
 * @package srag\DataTableUI\Component\Utils
 */
interface TableBuilder
{

    /**
     * @return Table
     */
    public function getTable() : Table;


    /**
     * @return string
     */
    public function render() : string;
}
