<?php

namespace srag\DataTable\Implementation;

use ILIAS\DI\Container;
use ILIAS\UI\Component\Component;
use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Implementation\Render\ResourceRegistry;
use ILIAS\UI\Implementation\Render\Template;
use ILIAS\UI\Renderer as RendererInterface;
use srag\DataTable\Component\Data\Data as DataInterface;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Table;
use srag\DataTable\Component\UserTableSettings\Settings;
use srag\DataTable\Implementation\Data\Data;

/**
 * Class Renderer
 *
 * @package srag\DataTable\Implementation
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Renderer extends AbstractComponentRenderer
{

    /**
     * @var Container
     */
    protected $dic;


    /**
     * @inheritDoc
     */
    protected function getComponentInterfaceName() : array
    {
        return [Table::class];
    }


    /**
     * @inheritDoc
     *
     * @param Table $component
     */
    public function render(Component $component, RendererInterface $default_renderer) : string
    {
        global $DIC;

        $this->dic = $DIC;

        $this->dic->language()->loadLanguageModule(Table::LANG_MODULE);

        $this->checkComponent($component);

        return $this->renderDataTable($component, $default_renderer);
    }


    /**
     * @param Table             $component
     * @param RendererInterface $renderer
     *
     * @return string
     */
    protected function renderDataTable(Table $component, RendererInterface $renderer) : string
    {
        $user_table_settings = $component->getUserTableSettingsStorage()->read($component->getTableId(), intval($this->dic->user()->getId()));

        $user_table_settings = $component->getBrowserFormat()->handleUserTableSettingsInput($component, $user_table_settings);

        $user_table_settings = $component->getUserTableSettingsStorage()->handleDefaultSettings($user_table_settings, $component);

        $data = $this->handleFetchData($component, $user_table_settings);

        $html = $this->handleFormat($component, $data, $user_table_settings, $renderer);

        $component->getUserTableSettingsStorage()->store($user_table_settings, $component->getTableId(), intval($this->dic->user()->getId()));

        return $html;
    }


    /**
     * @inheritDoc
     */
    public function registerResources(ResourceRegistry $registry) : void
    {
        parent::registerResources($registry);

        $dir = __DIR__;
        $dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1) . "/../..";

        $registry->register($dir . "/css/datatable.css");

        $registry->register($dir . "/js/datatable.min.js");
    }


    /**
     * @inheritDoc
     */
    protected function getTemplatePath(/*string*/ $name) : string
    {
        return __DIR__ . "/../../templates/" . $name;
    }


    /**
     * @param Table    $component
     * @param Settings $user_table_settings
     *
     * @return DataInterface
     */
    protected function handleFetchData(Table $component, Settings $user_table_settings) : DataInterface
    {
        if (!$component->getDataFetcher()->isFetchDataNeedsFilterFirstSet() || $user_table_settings->isFilterSet()) {
            $data = $component->getDataFetcher()->fetchData($user_table_settings);
        } else {
            $data = new Data([], 0);
        }

        return $data;
    }


    /**
     * @param Table             $component
     * @param DataInterface     $data
     * @param Settings          $user_table_settings
     * @param RendererInterface $renderer
     *
     * @return string
     */
    protected function handleFormat(Table $component, DataInterface $data, Settings $user_table_settings, RendererInterface $renderer) : string
    {
        $input_format_id = $component->getBrowserFormat()->getInputFormatId($component);

        /**
         * @var Format $format
         */
        $format = current(array_filter($component->getFormats(), function (Format $format) use ($input_format_id): bool {
            return ($format->getFormatId() === $input_format_id);
        }));

        if ($format === false) {
            $format = $component->getBrowserFormat();
        }

        $data = $format->render(function (string $name, bool $purge_unfilled_vars = true, bool $purge_unused_blocks = true) : Template {
            return $this->getTemplate($name, $purge_unfilled_vars, $purge_unused_blocks);
        }, $component, $data, $user_table_settings, $renderer);

        switch ($format->getOutputType()) {
            case Format::OUTPUT_TYPE_DOWNLOAD:
                $format->devliver($data, $component);

                return "";

            case Format::OUTPUT_TYPE_PRINT:
            default:
                return $data;
        }
    }
}
