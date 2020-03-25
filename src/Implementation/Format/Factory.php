<?php

namespace srag\DataTable\Implementation\Format;

use srag\DataTable\Component\Format\Browser\Factory as BrowserFactoryInterface;
use srag\DataTable\Component\Format\Factory as FactoryInterface;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Implementation\Format\Browser\Factory as BrowserFactory;
use srag\DataTable\Utils\DataTableTrait;
use srag\DIC\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTable\Implementation\Format
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Factory implements FactoryInterface
{

    use DICTrait;
    use DataTableTrait;
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
    public function browser() : BrowserFactoryInterface
    {
        return BrowserFactory::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function csv() : Format
    {
        return new CSVFormat();
    }


    /**
     * @inheritDoc
     */
    public function excel() : Format
    {
        return new ExcelFormat();
    }


    /**
     * @inheritDoc
     */
    public function html() : Format
    {
        return new HTMLFormat();
    }


    /**
     * @inheritDoc
     */
    public function pdf() : Format
    {
        return new PDFFormat();
    }
}
