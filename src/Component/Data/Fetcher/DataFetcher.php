<?php

namespace srag\DataTable\Component\Data\Fetcher;

use ILIAS\DI\Container;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Table;
use srag\DataTable\Component\UserTableSettings\Settings;

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
     * @param Settings $user_table_settings
     *
     * @return Data
     */
    public function fetchData(Settings $user_table_settings) : Data;


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


    /**
     * @param RowData[] $data
     * @param int       $max_count
     *
     * @return Data
     */
    public function data(array $data, int $max_count) : Data;


    /**
     * @param string $row_id
     * @param object $original_data
     *
     * @return RowData
     */
    public function propertyRowData(string $row_id, object $original_data) : RowData;


    /**
     * @param string $row_id
     * @param object $original_data
     *
     * @return RowData
     */
    public function getterRowData(string $row_id, object $original_data) : RowData;
}
