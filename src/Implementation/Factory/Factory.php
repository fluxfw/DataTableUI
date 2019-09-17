<?php

namespace srag\DataTable\Implementation\Factory;

use ILIAS\DI\Container;
use srag\DataTable\Component\Column\Column as ColumnInterface;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Factory\Factory as FactoryInterface;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Table as TableInterface;
use srag\DataTable\Implementation\Column\Column;
use srag\DataTable\Implementation\Format\CSVFormat;
use srag\DataTable\Implementation\Format\ExcelFormat;
use srag\DataTable\Implementation\Format\HTMLFormat;
use srag\DataTable\Implementation\Format\PDFFormat;
use srag\DataTable\Implementation\Table;

/**
 * Class Factory
 *
 * @package srag\DataTable\Implementation\Factory
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Factory implements FactoryInterface
{

    /**
     * @var Container
     */
    protected $dic;


    /**
     * @inheritDoc
     */
    public function __construct(Container $dic)
    {
        $this->dic = $dic;
    }


    /**
     * @inheritDoc
     */
    public function table(string $id, string $action_url, string $title, array $columns, DataFetcher $data_fetcher) : TableInterface
    {
        return new Table($id, $action_url, $title, $columns, $data_fetcher);
    }


    /**
     * @inheritDoc
     */
    public function column(string $key, string $title) : ColumnInterface
    {
        return new Column($key, $title);
    }


    /**
     * @inheritDoc
     */
    public function formatCSV() : Format
    {
        return new CSVFormat($this->dic);
    }


    /**
     * @inheritDoc
     */
    public function formatExcel() : Format
    {
        return new ExcelFormat($this->dic);
    }


    /**
     * @inheritDoc
     */
    public function formatPDF() : Format
    {
        return new PDFFormat($this->dic);
    }


    /**
     * @inheritDoc
     */
    public function formatHTML() : Format
    {
        return new HTMLFormat($this->dic);
    }
}
