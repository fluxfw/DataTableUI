<?php

namespace srag\DataTable\Implementation\Column\Action;

use Closure;
use ILIAS\UI\Component\Button\Shy;
use ILIAS\UI\Implementation\Component\Button\Button;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Action\ActionColumn;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Format\BrowserFormat;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Table;
use srag\DataTable\Implementation\Column\Formatter\AbstractFormatter;

/**
 * Class ActionFormatter
 *
 * @package srag\DataTable\Implementation\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ActionFormatter extends AbstractFormatter
{

    /**
     * @inheritDoc
     */
    public function formatHeaderCell(Format $format, Column $column, string $table_id, Renderer $renderer) : string
    {
        return $column->getTitle();
    }


    /**
     * @inheritDoc
     *
     * @param BrowserFormat $format
     * @param ActionColumn  $column
     */
    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id, Renderer $renderer) : string
    {
        $actions = $column->getActions($row);

        return $renderer->render($this->dic->ui()->factory()->dropdown()
            ->standard(array_map(function (Shy $button) use ($format, $row, $table_id): Shy {
                return Closure::bind(function () use ($button, $format, $row, $table_id)/*:void*/ {
                    if (empty($this->triggered_signals("click"))) {
                        $this->action = $format->getActionUrlWithParams($this->getAction(), [Table::ACTION_GET_VAR => $row->getRowId()], $table_id);
                    }

                    return $this;
                }, $button, Button::class)();
            }, $actions))->withLabel($column->getTitle()));
    }
}
