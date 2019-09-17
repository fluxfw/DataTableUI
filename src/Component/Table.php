<?php

namespace srag\DataTable\Component;

use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Input\Field\FilterInput;
use ILIAS\UI\Component\Input\Field\Input as FilterInput54;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Format\BrowserFormat;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\UserTableSettings\Storage\SettingsStorage;
use srag\DIC\Plugin\Pluginable;
use srag\DIC\Plugin\PluginInterface;

/**
 * Interface Table
 *
 * @package srag\DataTable\Component
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Table extends Component, Pluginable
{

    const ACTION_GET_VAR = "row_id";
    const MULTIPLE_SELECT_POST_VAR = "selected_row_ids";
    const LANG_MODULE = "datatable";


    /**
     * Table constructor
     *
     * @param string      $table_id
     * @param string      $action_url
     * @param string      $title
     * @param Column[]    $columns
     * @param DataFetcher $data_fetcher
     */
    public function __construct(string $table_id, string $action_url, string $title, array $columns, DataFetcher $data_fetcher);


    /**
     * @param PluginInterface $plugin
     *
     * @return self
     */
    public function withPlugin(PluginInterface $plugin) : self;


    /**
     * @return string
     */
    public function getTableId() : string;


    /**
     * @param string $table_id
     *
     * @return self
     */
    public function withTableId(string $table_id) : self;


    /**
     * @return string
     */
    public function getActionUrl() : string;


    /**
     * @param string $action_url
     *
     * @return self
     */
    public function withActionUrl(string $action_url) : self;


    /**
     * @return string
     */
    public function getTitle() : string;


    /**
     * @param string $title
     *
     * @return self
     */
    public function withTitle(string $title) : self;


    /**
     * @return Column[]
     */
    public function getColumns() : array;


    /**
     * @param Column[] $columns
     *
     * @return self
     */
    public function withColumns(array $columns) : self;


    /**
     * @return DataFetcher
     */
    public function getDataFetcher() : DataFetcher;


    /**
     * @param DataFetcher $data_fetcher
     *
     * @return self
     */
    public function withFetchData(DataFetcher $data_fetcher) : self;


    /**
     * @return FilterInput|FilterInput54[]
     */
    public function getFilterFields() : array;


    /**
     * @param FilterInput|FilterInput54[] $filter_fields
     *
     * @return self
     */
    public function withFilterFields(array $filter_fields) : self;


    /**
     * @return BrowserFormat
     */
    public function getBrowserFormat() : BrowserFormat;


    /**
     * @param BrowserFormat $browser_format
     *
     * @return self
     */
    public function withBrowserFormat(BrowserFormat $browser_format) : self;


    /**
     * @return Format[]
     */
    public function getFormats() : array;


    /**
     * @param Format[] $formats
     *
     * @return self
     */
    public function withFormats(array $formats) : self;


    /**
     * @return string[]
     */
    public function getMultipleActions() : array;


    /**
     * @param string[] $multiple_actions
     *
     * @return self
     */
    public function withMultipleActions(array $multiple_actions) : self;


    /**
     * @return SettingsStorage
     */
    public function getUserTableSettingsStorage() : SettingsStorage;


    /**
     * @param SettingsStorage $user_table_settings_storage
     *
     * @return self
     */
    public function withUserTableSettingsStorage(SettingsStorage $user_table_settings_storage) : self;


    /**
     * @return string
     */
    public function getActionRowId() : string;


    /**
     * @return string[]
     */
    public function getMultipleActionRowIds() : array;
}
