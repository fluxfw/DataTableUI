<?php

namespace srag\DataTable\Implementation\Column\Formatter;

use ILIAS\DI\Container;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Format\Format;

/**
 * Class LanguageVariableFormatter
 *
 * @package srag\DataTable\Implementation\Column\Formatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class LanguageVariableFormatter extends DefaultFormatter
{

    /**
     * @var string
     */
    protected $prefix;


    /**
     * @inheritDoc
     *
     * @param string $prefix Prefix or language module
     */
    public function __construct(Container $dic, string $prefix)
    {
        parent::__construct($dic);

        $this->prefix = $prefix;
    }


    /**
     * @inheritDoc
     */
    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id, Renderer $renderer) : string
    {
        $value = strval($value);

        if (!empty($value)) {
            if (!empty($this->prefix)) {
                $value = rtrim($this->prefix, "_") . "_" . $value;
            }

            $value = $this->dic->language()->txt($value);
        }

        return parent::formatRowCell($format, $value, $column, $row, $table_id, $renderer);
    }
}
