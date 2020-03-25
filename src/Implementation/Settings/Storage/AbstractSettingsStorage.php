<?php

namespace srag\DataTable\Implementation\Settings\Storage;

use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Settings\Settings;
use srag\DataTable\Component\Settings\Sort\SortField;
use srag\DataTable\Component\Settings\Storage\SettingsStorage;
use srag\DataTable\Component\Table;
use srag\DataTable\Utils\DataTableTrait;
use srag\DIC\DICTrait;

/**
 * Class AbstractSettingsStorage
 *
 * @package srag\DataTable\Implementation\Settings\Storage
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractSettingsStorage implements SettingsStorage
{

    use DICTrait;
    use DataTableTrait;


    /**
     * AbstractSettingsStorage constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function handleDefaultSettings(Settings $settings, Table $component) : Settings
    {
        if (!$settings->isFilterSet() && empty($settings->getSortFields())) {
            $settings = $settings->withSortFields(array_map(function (Column $column) use ($component): SortField {
                return self::dataTable()->settings()->sort()->sortField($column->getKey(), $column->getDefaultSortDirection());
            }, array_filter($component->getColumns(), function (Column $column) : bool {
                return ($column->isSortable() && $column->isDefaultSort());
            })));
        }

        if (!$settings->isFilterSet() && empty($settings->getSelectedColumns())) {
            $settings = $settings->withSelectedColumns(array_map(function (Column $column) : string {
                return $column->getKey();
            }, array_filter($component->getColumns(), function (Column $column) : bool {
                return ($column->isSelectable() && $column->isDefaultSelected());
            })));
        }

        return $settings;
    }


    /**
     * @param string $string
     *
     * @return string
     */
    protected function strToCamelCase(string $string) : string
    {
        return str_replace("_", "", ucwords($string, "_"));
    }
}
