<?php

namespace srag\DataTableUI\Implementation\Data;

use srag\DataTableUI\Component\Data\Data as DataInterface;
use srag\DataTableUI\Component\Data\Factory as FactoryInterface;
use srag\DataTableUI\Component\Data\Fetcher\Factory as FetcherFactoryInterface;
use srag\DataTableUI\Component\Data\Row\Factory as RowFactoryInterface;
use srag\DataTableUI\Implementation\Data\Fetcher\Factory as FetcherFactory;
use srag\DataTableUI\Implementation\Data\Row\Factory as RowFactory;
use srag\DataTableUI\Implementation\Utils\DataTableUITrait;
use srag\DIC\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTableUI\Implementation\Data
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Factory implements FactoryInterface
{

    use DICTrait;
    use DataTableUITrait;

    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Factory constructor
     */
    private function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function data(array $data, int $max_count) : DataInterface
    {
        return new Data($data, $max_count);
    }


    /**
     * @inheritDoc
     */
    public function fetcher() : FetcherFactoryInterface
    {
        return FetcherFactory::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function row() : RowFactoryInterface
    {
        return RowFactory::getInstance();
    }
}
