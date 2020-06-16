<?php

namespace srag\DataTableUI\Component\Format\Browser;

use srag\DataTableUI\Component\Format\Format;
use srag\DataTableUI\Component\Settings\Settings;
use srag\DataTableUI\Component\Table;

/**
 * Interface BrowserFormat
 *
 * @package srag\DataTableUI\Component\Format\Browser
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface BrowserFormat extends Format
{

    /**
     * @param string $key
     * @param string $table_id
     *
     * @return string
     */
    public function actionParameter(string $key, string $table_id) : string;


    /**
     * @param string $table_id
     *
     * @return string
     */
    public function getActionRowId(string $table_id) : string;


    /**
     * @param string $action_url
     * @param array  $params
     * @param string $table_id
     *
     * @return string
     */
    public function getActionUrlWithParams(string $action_url, array $params, string $table_id) : string;


    /**
     * @param Table $component
     *
     * @return string|null
     */
    public function getInputFormatId(Table $component) : ?string;


    /**
     * @param string $table_id
     *
     * @return string[]
     */
    public function getMultipleActionRowIds(string $table_id) : array;


    /**
     * @param Table    $component
     * @param Settings $settings
     *
     * @return Settings
     */
    public function handleSettingsInput(Table $component, Settings $settings) : Settings;
}
