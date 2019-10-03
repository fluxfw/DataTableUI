<?php

namespace srag\DataTable\Component\Format;

use ILIAS\UI\Renderer;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Settings\Settings;
use srag\DataTable\Component\Table;

/**
 * Interface Format
 *
 * @package srag\DataTable\Component\Format
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Format
{

    /**
     * @var string
     */
    const FORMAT_BROWSER = "browser";
    /**
     * @var string
     */
    const FORMAT_CSV = "csv";
    /**
     * @var string
     */
    const FORMAT_EXCEL = "excel";
    /**
     * @var string
     */
    const FORMAT_PDF = "pdf";
    /**
     * @var string
     */
    const FORMAT_HTML = "html";
    /**
     * @var int
     */
    const OUTPUT_TYPE_PRINT = 1;
    /**
     * @var int
     */
    const OUTPUT_TYPE_DOWNLOAD = 2;


    /**
     * @return string
     */
    public function getFormatId() : string;


    /**
     * @param Table $component
     *
     * @return string
     */
    public function getDisplayTitle(Table $component) : string;


    /**
     * @return int
     */
    public function getOutputType() : int;


    /**
     * @return object
     */
    public function getTemplate() : object;


    /**
     * @param callable $get_template
     * @param Table    $component
     * @param Data     $data
     * @param Settings $settings
     * @param Renderer $renderer
     *
     * @return string
     */
    public function render(callable $get_template, Table $component, Data $data, Settings $settings, Renderer $renderer) : string;


    /**
     * @param string $data
     * @param Table  $component
     */
    public function deliverDownload(string $data, Table $component) : void;
}
