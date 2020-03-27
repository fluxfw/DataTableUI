<?php

namespace srag\DataTableUI\Component\Column;

use srag\DataTableUI\Component\Column\Formatter\Factory as FormatterFactory;

/**
 * Interface Factory
 *
 * @package srag\DataTableUI\Component\Column
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Factory
{

    /**
     * @param string $key
     * @param string $title
     *
     * @return Column
     */
    public function column(string $key, string $title) : Column;


    /**
     * @return FormatterFactory
     */
    public function formatter() : FormatterFactory;
}
