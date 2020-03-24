<?php

namespace srag\DataTable\Component;

use ILIAS\UI\Component\ViewControl\Pagination;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Column\Formatter\Formatter;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Format\BrowserFormat;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Settings\Settings;
use srag\DataTable\Component\Settings\Sort\SortField;
use srag\DataTable\Component\Settings\Storage\SettingsStorage;
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
     * @param string $key
     * @param string $title
     *
     * @return Column
     */
    public function column(string $key, string $title) : Column;


    /**
     * @return Format
     */
    public function csvFormat() : Format;


    /**
     * @param RowData[] $data
     * @param int       $max_count
     *
     * @return Data
     */
    public function data(array $data, int $max_count) : Data;


    /**
     * @return Formatter
     */
    public function dateColumnFormatter() : Formatter;


    /**
     * @return BrowserFormat
     */
    public function defaultBrowserFormat() : BrowserFormat;


    /**
     * @return Formatter
     */
    public function defaultFormatter() : Formatter;


    /**
     * @return SettingsStorage
     */
    public function defaultSettingsStorage() : SettingsStorage;


    /**
     * @return Format
     */
    public function excelFormat() : Format;


    /**
     * @param string $row_id
     * @param object $original_data
     *
     * @return RowData
     */
    public function getterRowData(string $row_id, object $original_data) : RowData;


    /**
     * @return Format
     */
    public function htmlFormat() : Format;


    /**
     * @param PluginInterface $plugin
     */
    public function installLanguages(PluginInterface $plugin) : void;


    /**
     * @param string $prefix
     *
     * @return Formatter
     */
    public function languageVariableFormatter(string $prefix) : Formatter;


    /**
     * @return Formatter
     */
    public function learningProgressFormatter() : Formatter;


    /**
     * @return Formatter
     */
    public function linkColumnFormatter() : Formatter;


    /**
     * @return Format
     */
    public function pdfFormat() : Format;


    /**
     * @param string $row_id
     * @param object $original_data
     *
     * @return RowData
     */
    public function propertyRowData(string $row_id, object $original_data) : RowData;


    /**
     * @param Pagination $pagination
     *
     * @return Settings
     */
    public function settings(Pagination $pagination) : Settings;


    /**
     * @param string $sort_field
     * @param int    $sort_field_direction
     *
     * @return SortField
     */
    public function sortField(string $sort_field, int $sort_field_direction) : SortField;


    /**
     * @param object[] $data
     * @param string   $id_key
     *
     * @return DataFetcher
     */
    public function staticDataFetcher(array $data, string $id_key) : DataFetcher;


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
}
