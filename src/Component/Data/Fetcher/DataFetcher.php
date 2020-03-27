<?php

namespace srag\DataTableUI\Component\Data\Fetcher;

use srag\DataTableUI\Component\Data\Data;
use srag\DataTableUI\Component\Settings\Settings;
use srag\DataTableUI\Component\Table;

/**
 * Interface DataFetcher
 *
 * @package srag\DataTableUI\Component\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface DataFetcher
{

    /**
     * @param Settings $settings
     *
     * @return Data
     */
    public function fetchData(Settings $settings) : Data;


    /**
     * @param Table $component
     *
     * @return string
     */
    public function getNoDataText(Table $component) : string;


    /**
     * @return bool
     */
    public function isFetchDataNeedsFilterFirstSet() : bool;
}
