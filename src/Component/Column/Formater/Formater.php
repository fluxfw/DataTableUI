<?php

namespace srag\DataTable\Component\Column\Formater;

use ILIAS\DI\Container;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Format\Format;

/**
 * Interface Formater
 *
 * @package srag\DataTable\Component\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Formater
{

    /**
     * Formater constructor
     *
     * @param Container $dic
     */
    public function __construct(Container $dic);


    /**
     * @param Format   $format
     * @param Column   $column
     * @param string   $table_id
     * @param Renderer $renderer
     *
     * @return string
     */
    public function formatHeaderCell(Format $format, Column $column, string $table_id, Renderer $renderer) : string;


    /**
     * @param Format   $format
     * @param mixed    $value
     * @param Column   $column
     * @param RowData  $row
     * @param string   $table_id
     * @param Renderer $renderer
     *
     * @return string
     */
    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id, Renderer $renderer) : string;
}
