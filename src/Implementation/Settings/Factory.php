<?php

namespace srag\DataTable\Implementation\Settings;

use ILIAS\UI\Component\ViewControl\Pagination;
use srag\DataTable\Component\Settings\Factory as FactoryInterface;
use srag\DataTable\Component\Settings\Settings as SettingsInterface;
use srag\DataTable\Component\Settings\Sort\Factory as SortFactoryInterface;
use srag\DataTable\Component\Settings\Storage\Factory as StorageFactoryInterface;
use srag\DataTable\Implementation\Settings\Sort\Factory as SortFactory;
use srag\DataTable\Implementation\Settings\Storage\Factory as StorageFactory;
use srag\DataTable\Utils\DataTableTrait;
use srag\DIC\DICTrait;

/**
 * Class Factory
 *
 * @package srag\DataTable\Implementation\Settings
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
    public function settings(Pagination $pagination) : SettingsInterface
    {
        return new Settings($pagination);
    }


    /**
     * @inheritDoc
     */
    public function sort() : SortFactoryInterface
    {
        return SortFactory::getInstance();
    }


    /**
     * @inheritDoc
     */
    public function storage() : StorageFactoryInterface
    {
        return StorageFactory::getInstance();
    }
}
