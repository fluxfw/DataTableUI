<?php

namespace srag\DataTableUI\Component\Format\Browser\Filter;

use srag\CustomInputGUIs\FormBuilder\FormBuilder;
use srag\DataTableUI\Component\Format\Browser\BrowserFormat;
use srag\DataTableUI\Component\Settings\Settings;
use srag\DataTableUI\Component\Table;

/**
 * Interface Factory
 *
 * @package srag\DataTableUI\Component\Format\Browser\Filter
 */
interface Factory
{

    /**
     * @param BrowserFormat $parent
     * @param Table         $component
     * @param Settings      $settings
     *
     * @return FormBuilder
     */
    public function formBuilder(BrowserFormat $parent, Table $component, Settings $settings) : FormBuilder;
}
