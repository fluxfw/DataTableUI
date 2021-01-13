<?php

namespace srag\DataTableUI\Implementation\Column\Formatter;

use srag\DataTableUI\Component\Column\Column;
use srag\DataTableUI\Component\Data\Row\RowData;
use srag\DataTableUI\Component\Format\Format;

/**
 * Class MultilineFormatter
 *
 * @package srag\DataTableUI\Implementation\Column\Formatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class MultilineFormatter extends DefaultFormatter
{

    /**
     * @inheritDoc
     */
    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id) : string
    {
        return nl2br(implode("\n", array_map("htmlspecialchars", explode("\n", strval($value)))), false);
    }
}
