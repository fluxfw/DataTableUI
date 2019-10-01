<?php

namespace srag\DataTable\Implementation\Column\Action;

use ILIAS\UI\Component\Button\Shy;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Action\ActionColumn;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Format\BrowserFormat;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Table;
use srag\DataTable\Implementation\Column\Formater\AbstractFormater;

/**
 * Class ActionFormater
 *
 * @package srag\DataTable\Implementation\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ActionFormater extends AbstractFormater
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
            ->standard(array_map(function (string $title, string $action) use ($format, $row, $table_id): Shy {
                return $this->dic->ui()->factory()->button()
                    ->shy($title, $format->getActionUrlWithParams($action, [Table::ACTION_GET_VAR => $row->getRowId()], $table_id));
            }, array_keys($actions), $actions))->withLabel($column->getTitle()));
    }
}
