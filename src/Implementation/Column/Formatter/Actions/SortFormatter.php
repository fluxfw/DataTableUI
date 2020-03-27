<?php

namespace srag\DataTableUI\Implementation\Column\Formatter\Actions;

use srag\CustomInputGUIs\Waiter\Waiter;
use srag\DataTableUI\Component\Column\Column;
use srag\DataTableUI\Component\Data\Row\RowData;
use srag\DataTableUI\Component\Format\Format;
use srag\DataTableUI\Component\Table;

/**
 * Class SortFormatter
 *
 * @package srag\DataTableUI\Implementation\Column\Formatter\Actions
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class SortFormatter extends AbstractActionsFormatter
{

    /**
     * @var string
     */
    protected $sort_up_action_url;
    /**
     * @var string
     */
    protected $sort_down_action_url;


    /**
     * @inheritDoc
     *
     * @param string $sort_up_action_url
     * @param string $sort_down_action_url
     */
    public function __construct(string $sort_up_action_url, string $sort_down_action_url)
    {
        parent::__construct();

        $this->sort_up_action_url = $sort_up_action_url;
        $this->sort_down_action_url = $sort_down_action_url;
    }


    /**
     * @inheritDoc
     */
    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id) : string
    {
        if (self::version()->is60()) {
            $glyph_factory = self::dic()->ui()->factory()->symbol()->glyph();
        } else {
            $glyph_factory = self::dic()->ui()->factory()->glyph();
        }

        return self::output()->getHTML([
            $glyph_factory->sortAscending()->withAdditionalOnLoadCode(function (string $id) use ($format, $row, $table_id): string {
                Waiter::init(Waiter::TYPE_WAITER);

                return '
            $("#' . $id . '").click(function () {
                il.waiter.show();
                var row = $(this).parent().parent();
                $.ajax({
                    url: ' . json_encode($format->getActionUrlWithParams($this->sort_up_action_url, [Table::ACTION_GET_VAR => $row->getRowId()], $table_id)) . ',
                    type: "GET"
                 }).always(function () {
                    il.waiter.hide();
               }).success(function() {
                    row.insertBefore(row.prev());
                });
            });';
            }),
            $glyph_factory->sortDescending()->withAdditionalOnLoadCode(function (string $id) use ($format, $row, $table_id) : string {
                return '
            $("#' . $id . '").click(function () {
                il.waiter.show();
                var row = $(this).parent().parent();
                $.ajax({
                    url: ' . json_encode($format->getActionUrlWithParams($this->sort_down_action_url, [Table::ACTION_GET_VAR => $row->getRowId()], $table_id)) . ',
                    type: "GET"
                }).always(function () {
                    il.waiter.hide();
                }).success(function() {
                    row.insertAfter(row.next());
                });
        });';
            })
        ]);
    }


    /**
     * @inheritDoc
     */
    protected function getActions(RowData $row) : array
    {
        return [];
    }
}
