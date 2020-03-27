<?php

namespace srag\DataTableUI\Component\Column\Formatter\Actions;

/**
 * Interface Factory
 *
 * @package srag\DataTableUI\Component\Column\Formatter\Actions
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Factory
{

    /**
     * @param string $sort_up_action_url
     * @param string $sort_down_action_url
     *
     * @return ActionsFormatter
     */
    public function sort(string $sort_up_action_url, string $sort_down_action_url) : ActionsFormatter;
}
