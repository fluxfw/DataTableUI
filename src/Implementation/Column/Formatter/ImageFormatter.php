<?php

namespace srag\DataTableUI\Implementation\Column\Formatter;

use srag\DataTableUI\Component\Column\Column;
use srag\DataTableUI\Component\Data\Row\RowData;
use srag\DataTableUI\Component\Format\Format;

/**
 * Class ImageFormatter
 *
 * @package srag\DataTableUI\Implementation\Column\Formatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ImageFormatter extends DefaultFormatter
{

    /**
     * @inheritDoc
     */
    public function formatRowCell(Format $format, $image, Column $column, RowData $row, string $table_id) : string
    {
        if (!empty($image)) {
            return self::output()->getHTML(self::dic()->ui()->factory()->image()->standard($image, ""));
        } else {
            return "";
        }
    }
}