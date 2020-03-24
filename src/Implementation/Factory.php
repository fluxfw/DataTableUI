<?php

namespace srag\DataTable\Implementation;

use ILIAS\UI\Component\ViewControl\Pagination;
use srag\DataTable\Component\Column\Column as ColumnInterface;
use srag\DataTable\Component\Column\Formatter\Formatter;
use srag\DataTable\Component\Data\Data as DataInterface;
use srag\DataTable\Component\Data\Fetcher\DataFetcher;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Factory as FactoryInterface;
use srag\DataTable\Component\Format\BrowserFormat;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Settings\Settings as SettingsInterface;
use srag\DataTable\Component\Settings\Sort\SortField as SortFieldInterface;
use srag\DataTable\Component\Settings\Storage\SettingsStorage;
use srag\DataTable\Component\Table as TableInterface;
use srag\DataTable\Implementation\Column\Column;
use srag\DataTable\Implementation\Column\Formatter\DateColumnFormatter;
use srag\DataTable\Implementation\Column\Formatter\DefaultFormatter;
use srag\DataTable\Implementation\Column\Formatter\LanguageVariableFormatter;
use srag\DataTable\Implementation\Column\Formatter\LearningProgressFormatter;
use srag\DataTable\Implementation\Column\Formatter\LinkColumnFormatter;
use srag\DataTable\Implementation\Data\Data;
use srag\DataTable\Implementation\Data\Fetcher\StaticDataFetcher;
use srag\DataTable\Implementation\Data\Row\GetterRowData;
use srag\DataTable\Implementation\Data\Row\PropertyRowData;
use srag\DataTable\Implementation\Format\CSVFormat;
use srag\DataTable\Implementation\Format\DefaultBrowserFormat;
use srag\DataTable\Implementation\Format\ExcelFormat;
use srag\DataTable\Implementation\Format\HTMLFormat;
use srag\DataTable\Implementation\Format\PDFFormat;
use srag\DataTable\Implementation\Settings\Settings;
use srag\DataTable\Implementation\Settings\Sort\SortField;
use srag\DataTable\Implementation\Settings\Storage\DefaultSettingsStorage;
use srag\DataTable\Utils\DataTableTrait;
use srag\DIC\DICTrait;
use srag\DIC\Plugin\PluginInterface;
use srag\DIC\Util\LibraryLanguageInstaller;

/**
 * Class Factory
 *
 * @package srag\DataTable\Implementation
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Factory implements FactoryInterface
{

    use DICTrait;
    use DataTableTrait;
    /**
     * @var self|null
     */
    protected static $instance = null;


    /**
     * @return self
     */
    public static function getInstance() : self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    /**
     * Factory constructor
     */
    private function __construct()
    {

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
    public function csvFormat() : Format
    {
        return new CSVFormat();
    }


    /**
     * @inheritDoc
     */
    public function data(array $data, int $max_count) : DataInterface
    {
        return new Data($data, $max_count);
    }


    /**
     * @inheritDoc
     */
    public function dateColumnFormatter() : Formatter
    {
        return new DateColumnFormatter();
    }


    /**
     * @inheritDoc
     */
    public function defaultBrowserFormat() : BrowserFormat
    {
        return new DefaultBrowserFormat();
    }


    /**
     * @inheritDoc
     */
    public function defaultFormatter() : Formatter
    {
        return new DefaultFormatter();
    }


    /**
     * @inheritDoc
     */
    public function defaultSettingsStorage() : SettingsStorage
    {
        return new DefaultSettingsStorage();
    }


    /**
     * @inheritDoc
     */
    public function excelFormat() : Format
    {
        return new ExcelFormat();
    }


    /**
     * @inheritDoc
     */
    public function getterRowData(string $row_id, object $original_data) : RowData
    {
        return new GetterRowData($row_id, $original_data);
    }


    /**
     * @inheritDoc
     */
    public function htmlFormat() : Format
    {
        return new HTMLFormat();
    }


    /**
     * @inheritDoc
     */
    public function installLanguages(PluginInterface $plugin) : void
    {
        LibraryLanguageInstaller::getInstance()->withPlugin($plugin)->withLibraryLanguageDirectory(__DIR__
            . "/../../lang")->updateLanguages();
    }


    /**
     * @inheritDoc
     */
    public function languageVariableFormatter(string $prefix) : Formatter
    {
        return new LanguageVariableFormatter($prefix);
    }


    /**
     * @inheritDoc
     */
    public function learningProgressFormatter() : Formatter
    {
        return new LearningProgressFormatter();
    }


    /**
     * @inheritDoc
     */
    public function linkColumnFormatter() : Formatter
    {
        return new LinkColumnFormatter();
    }


    /**
     * @inheritDoc
     */
    public function pdfFormat() : Format
    {
        return new PDFFormat();
    }


    /**
     * @inheritDoc
     */
    public function propertyRowData(string $row_id, object $original_data) : RowData
    {
        return new PropertyRowData($row_id, $original_data);
    }


    /**
     * @inheritDoc
     */
    public function settings(Pagination $pagination) : SettingsInterface
    {
        return new Settings($pagination);
    }


    /**
     * @inheritDoc
     */
    public function sortField(string $sort_field, int $sort_field_direction) : SortFieldInterface
    {
        return new SortField($sort_field, $sort_field_direction);
    }


    /**
     * @inheritDoc
     */
    public function staticDataFetcher(array $data, string $id_key) : DataFetcher
    {
        return new StaticDataFetcher($data, $id_key);
    }


    /**
     * @inheritDoc
     */
    public function table(string $table_id, string $action_url, string $title, array $columns, DataFetcher $data_fetcher) : TableInterface
    {
        return new Table($table_id, $action_url, $title, $columns, $data_fetcher);
    }
}
