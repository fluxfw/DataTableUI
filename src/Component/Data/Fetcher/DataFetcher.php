<?php

namespace srag\DataTable\Component\Data\Fetcher;

use ILIAS\DI\Container;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Table;
use srag\DataTable\Component\Settings\Settings;

/**
 * Interface DataFetcher
 *
 * @package srag\DataTable\Component\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface DataFetcher
{

    /**
     * DataFetcher constructor
     *
     * @param Container $dic
     */
    public function __construct(Container $dic);


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
