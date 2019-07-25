<?php

namespace srag\DataTable\Component\Format;

use srag\DataTable\Component\UserTableSettings\Settings;
use srag\DataTable\Component\Table;

/**
 * Interface BrowserFormat
 *
 * @package srag\DataTable\Component\Format
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface BrowserFormat extends Format {

	/**
	 * @param Table $component
	 *
	 * @return string|null
	 */
	public function getInputFormatId(Table $component): ?string;


	/**
	 * @param Table    $component
	 * @param Settings $user_table_settings
	 *
	 * @return Settings
	 */
	public function handleUserTableSettingsInput(Table $component, Settings $user_table_settings): Settings;
}
