<?php

namespace srag\DataTable\Implementation\Data\Fetcher;

use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Table;
use srag\DataTable\Utils\DataTableTrait;
use srag\DIC\DICTrait;

/**
 * Class AbstractDataFetcher
 *
 * @package srag\DataTable\Implementation\Data\Fetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractDataFetcher implements DataFetcher
{

    use DICTrait;
    use DataTableTrait;


    /**
     * AbstractDataFetcher constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function getNoDataText(Table $component) : string
    {
        return $component->getPlugin()->translate("no_data", Table::LANG_MODULE);
    }


    /**
     * @inheritDoc
     */
    public function isFetchDataNeedsFilterFirstSet() : bool
    {
        return false;
    }
}
