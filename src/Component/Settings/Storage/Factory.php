<?php

namespace srag\DataTableUI\Component\Settings\Storage;

/**
 * Interface Factory
 *
 * @package srag\DataTableUI\Component\Settings\Storage
 */
interface Factory
{

    /**
     * @return SettingsStorage
     */
    public function default() : SettingsStorage;
}
