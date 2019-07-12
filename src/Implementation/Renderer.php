<?php

namespace srag\DataTable\Implementation;

use Closure;
use ILIAS\DI\Container;
use ILIAS\UI\Component\Component;
use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Implementation\Render\ResourceRegistry;
use ILIAS\UI\Implementation\Render\TemplateFactory;
use ILIAS\UI\Renderer as RendererInterface;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Filter\Filter;
use srag\DataTable\Component\Filter\Sort\FilterSortField;
use srag\DataTable\Component\Filter\Storage\FilterStorage;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Table;
use srag\DataTable\Implementation\Format\BrowserFormat;

/**
 * Class Renderer
 *
 * @package srag\DataTable\Implementation
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Renderer extends AbstractComponentRenderer {

	/**
	 * @var Container
	 */
	protected $dic;


	/**
	 * @inheritDoc
	 */
	protected function getComponentInterfaceName(): array {
		return [ Table::class ];
	}


	/**
	 * @inheritDoc
	 *
	 * @param Table $component
	 */
	public function render(Component $component, RendererInterface $default_renderer): string {
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
	protected function renderDataTable(Table $component, RendererInterface $renderer): string {
		$filter = $component->getFilterStorage()->read($component->getTableId(), $this->dic->user()->getId());

		$browser_format = new BrowserFormat($this->dic);

		$filter = $browser_format->handleFilterInput($browser_format, $component, $filter);

		$filter = $this->handleDefaultSort($component, $filter);

		$filter = $this->handleDefaultSelectedColumns($component, $filter);

		$data = $this->handleFetchData($component, $filter);

		$html = $this->handleFormat($browser_format, $component, $data, $filter, $renderer);

		$component->getFilterStorage()->store($filter);

		return $html;
	}


	/**
	 * @inheritDoc
	 */
	public function registerResources(ResourceRegistry $registry): void {
		parent::registerResources($registry);

		$dir = __DIR__;
		$dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1) . "/../..";

		$registry->register($dir . "/css/datatable.css");

		$registry->register($dir . "/js/datatable.min.js");
	}


	/**
	 * @inheritDoc
	 */
	protected function getTemplatePath(/*string*/ $name): string {
		return __DIR__ . "/../../templates/" . $name;
	}


	/**
	 * @param Table  $component
	 * @param Filter $filter
	 *
	 * @return Filter
	 */
	protected function handleDefaultSort(Table $component, Filter $filter): Filter {
		if (!$filter->isFilterSet() && empty($filter->getSortFields())) {
			$filter = $filter->withSortFields(array_map(function (Column $column) use ($component): FilterSortField {
				return $component->getFilterStorage()->sortField($column->getKey(), $column->getDefaultSortDirection());
			}, array_filter($component->getColumns(), function (Column $column): bool {
				return ($column->isSortable() && $column->isDefaultSort());
			})));
		}

		return $filter;
	}


	/**
	 * @param Table  $component
	 * @param Filter $filter
	 *
	 * @return Filter
	 */
	protected function handleDefaultSelectedColumns(Table $component, Filter $filter): Filter {
		if (!$filter->isFilterSet() && empty($filter->getSelectedColumns())) {
			$filter = $filter->withSelectedColumns(array_map(function (Column $column): string {
				return $column->getKey();
			}, array_filter($component->getColumns(), function (Column $column): bool {
				return ($column->isSelectable() && $column->isDefaultSelected());
			})));
		}

		return $filter;
	}


	/**
	 * @param Table  $component
	 * @param Filter $filter
	 *
	 * @return Data
	 */
	protected function handleFetchData(Table $component, Filter $filter): Data {
		if (!$component->isFetchDataNeedsFilterFirstSet() || $filter->isFilterSet()) {
			$data = $component->getDataFetcher()->fetchData($filter);
		} else {
			$data = $component->getDataFetcher()->data([], 0);
		}

		return $data;
	}


	/**
	 * @param BrowserFormat     $browser_format
	 * @param Table             $component
	 * @param Data              $data
	 * @param Filter            $filter
	 * @param RendererInterface $renderer
	 *
	 * @return string
	 */
	protected function handleFormat(BrowserFormat $browser_format, Table $component, Data $data, Filter $filter, RendererInterface $renderer): string {
		$formats = $component->getFormats();
		array_unshift($formats, $browser_format);

		$export_format_id = strval(filter_input(INPUT_GET, BrowserFormat::actionParameter(FilterStorage::VAR_EXPORT_FORMAT_ID, $component->getTableId())));

		if (empty($export_format_id)) {
			$export_format_id = Format::FORMAT_BROWSER;
		}

		/**
		 * @var Format|null $format
		 */
		$format = current(array_filter($formats, function (Format $format) use ($export_format_id): bool {
			return ($format->getFormatId() === $export_format_id);
		}));

		if ($format === null) {
			return "";
		}

		$data = $format->render(Closure::bind(function (): TemplateFactory { return $this->tpl_factory; }, $this, AbstractComponentRenderer::class)(), $this->getTemplatePath(""), $component, $data, $filter, $renderer); // TODO: `$this->tpl_factory` is private!!!

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
