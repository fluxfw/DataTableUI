<?php

namespace srag\DataTable\Component\Factory;

use ILIAS\DI\Container;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Table;

/**
 * Interface Factory
 *
 * @package srag\DataTable\Component\Factory
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Factory
{

    /**
     * Factory constructor
     *
     * @param Container $dic
     */
    public function __construct(Container $dic);


    /**
     * @param string      $id
     * @param string      $action_url
     * @param string      $title
     * @param Column[]    $columns
     * @param DataFetcher $data_fetcher
     *
     * @return Table
     */
    public function table(string $id, string $action_url, string $title, array $columns, DataFetcher $data_fetcher) : Table;


    /**
     * @param string $key
     * @param string $title
     *
     * @return Column
     */
    public function column(string $key, string $title) : Column;


    /**
     * @return Format
     */
    public function formatCSV() : Format;


    /**
     * @return Format
     */
    public function formatExcel() : Format;


    /**
     * @return Format
     */
    public function formatPDF() : Format;


    /**
     * @return Format
     */
    public function formatHTML() : Format;
}
