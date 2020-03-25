<?php

namespace srag\DataTable\Implementation\Column\Formatter\Actions;

use Closure;
use ILIAS\UI\Component\Button\Shy;
use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Link\Standard as StandardInterface;
use ILIAS\UI\Implementation\Component\Button\Button;
use ILIAS\UI\Implementation\Component\Link\Standard;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Column\Formatter\Actions\ActionsFormatter;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Format\Browser\BrowserFormat;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Table;
use srag\DataTable\Implementation\Column\Formatter\DefaultFormatter;

/**
 * Class AbstractActionsFormatter
 *
 * @package srag\DataTable\Implementation\Column\Formatter\Actions
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractActionsFormatter extends DefaultFormatter implements ActionsFormatter
{

    /**
     * @inheritDoc
     *
     * @param BrowserFormat $format
     */
    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id) : string
    {
        return self::output()->getHTML(self::dic()->ui()->factory()->dropdown()
            ->standard(array_map(function (Component $button) use ($format, $row, $table_id): Component {
                if ($button instanceof Shy) {
                    return Closure::bind(function () use ($button, $format, $row, $table_id): Shy {
                        if (!empty($this->action) && empty($this->triggered_signals["click"])) {
                            $this->action = $format->getActionUrlWithParams($this->action, [Table::ACTION_GET_VAR => $row->getRowId()], $table_id);
                        }

                        return $this;
                    }, $button, Button::class)();
                }

                if ($button instanceof StandardInterface) {
                    return Closure::bind(function () use ($button, $format, $row, $table_id): StandardInterface {
                        if (!empty($this->action)) {
                            $this->action = $format->getActionUrlWithParams($this->action, [Table::ACTION_GET_VAR => $row->getRowId()], $table_id);
                        }

                        return $this;
                    }, $button, Standard::class)();
                }

                return $button;
            }, $this->getActions($row)))->withLabel($column->getTitle()));
    }


    /**
     * @param RowData $row
     *
     * @return Component[]
     */
    protected abstract function getActions(RowData $row) : array;
}
