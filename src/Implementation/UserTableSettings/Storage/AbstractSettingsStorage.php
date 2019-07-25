<?php

namespace srag\DataTable\Implementation\UserTableSettings\Storage;

use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Table;
use srag\DataTable\Component\UserTableSettings\Settings as SettingsInterface;
use srag\DataTable\Component\UserTableSettings\Sort\SortField as SortFieldInterface;
use srag\DataTable\Component\UserTableSettings\Storage\SettingsStorage;
use srag\DataTable\Implementation\UserTableSettings\Settings;
use srag\DataTable\Implementation\UserTableSettings\Sort\SortField;

/**
 * Class AbstractSettingsStorage
 *
 * @package srag\DataTable\Implementation\UserTableSettings\Storage
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractSettingsStorage implements SettingsStorage {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function handleDefaultSettings(SettingsInterface $user_table_settings, Table $component): SettingsInterface {
		if (!$user_table_settings->isFilterSet() && empty($user_table_settings->getSortFields())) {
			$user_table_settings = $user_table_settings->withSortFields(array_map(function (Column $column) use ($component): SortFieldInterface {
				return $this->sortField($column->getKey(), $column->getDefaultSortDirection());
			}, array_filter($component->getColumns(), function (Column $column): bool {
				return ($column->isSortable() && $column->isDefaultSort());
			})));
		}

		if (!$user_table_settings->isFilterSet() && empty($user_table_settings->getSelectedColumns())) {
			$user_table_settings = $user_table_settings->withSelectedColumns(array_map(function (Column $column): string {
				return $column->getKey();
			}, array_filter($component->getColumns(), function (Column $column): bool {
				return ($column->isSelectable() && $column->isDefaultSelected());
			})));
		}

		return $user_table_settings;
	}


	/**
	 * @inheritDoc
	 */
	public function sortField(string $sort_field, int $sort_field_direction): SortFieldInterface {
		return new SortField($sort_field, $sort_field_direction);
	}


	/**
	 * @inheritDoc
	 */
	public function userTableSettings(): SettingsInterface {
		return new Settings();
	}


	/**
	 * @param string $string
	 *
	 * @return string
	 */
	protected function strToCamelCase(string $string): string {
		return str_replace("_", "", ucwords($string, "_"));
	}
}