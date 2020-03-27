<?php

namespace srag\DataTableUI\Component\Settings\Storage;

/**
 * Interface Factory
 *
 * @package srag\DataTableUI\Component\Settings\Storage
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Factory
{

    /**
     * @return SettingsStorage
     */
    public function default() : SettingsStorage;
}
