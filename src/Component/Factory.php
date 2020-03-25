<?php

namespace srag\DataTable\Component;

use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Column\Factory as ColumnFactory;
use srag\DataTable\Component\Data\Factory as DataFactory;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Format\Factory as FormatFactory;
use srag\DataTable\Component\Settings\Factory as SettingsFactory;
use srag\DIC\Plugin\PluginInterface;

/**
 * Interface Factory
 *
 * @package srag\DataTable\Component
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Factory
{

    /**
     * @return ColumnFactory
     */
    public function column() : ColumnFactory;


    /**
     * @return ColumnFactory
     */
    public function data() : DataFactory;


    /**
     * @return ColumnFactory
     */
    public function format() : FormatFactory;


    /**
     * @return ColumnFactory
     */
    public function settings() : SettingsFactory;


    /**
     * @param string      $table_id
     * @param string      $action_url
     * @param string      $title
     * @param Column[]    $columns
     * @param DataFetcher $data_fetcher
     *
     * @return Table
     */
    public function table(string $table_id, string $action_url, string $title, array $columns, DataFetcher $data_fetcher) : Table;


    /**
     * @param PluginInterface $plugin
     */
    public function installLanguages(PluginInterface $plugin) : void;
}
