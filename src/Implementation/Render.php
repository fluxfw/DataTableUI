<?php

namespace srag\TableUI\Implementation;

use ILIAS\UI\Component\Component;
use ILIAS\UI\Implementation\Render\AbstractComponentRenderer;
use ILIAS\UI\Implementation\Render\ilTemplateWrapper;
use ILIAS\UI\Renderer as RendererInterface;
use ilTemplate;
use srag\DIC\DICTrait;
use srag\TableUI\Component\TableUI as TableUIInterface;

/**
 * Class Render
 *
 * @package srag\TableUI\Implementation
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Render extends AbstractComponentRenderer {

	use DICTrait;


	/**
	 * @inheritDoc
	 */
	protected function getComponentInterfaceName(): array {
		return [ TableUIInterface::class ];
	}


	/**
	 * @inheritDoc
	 */
	public function render(Component $component, RendererInterface $default_renderer) {
		$this->checkComponent($component);

		return $this->renderStandard($component, $default_renderer);
	}


	/**
	 * @param TableUIInterface  $component
	 * @param RendererInterface $default_renderer
	 *
	 * @return string
	 */
	protected function renderStandard(TableUIInterface $component, RendererInterface $default_renderer): string {
		$dir = __DIR__;
		$dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1) . "/../..";

		self::dic()->mainTemplate()->addCss($dir . "/css/tableui.css");

		self::dic()->mainTemplate()->addJavaScript($dir . "/js/tableui.min.js");

		$tpl = new ilTemplateWrapper(self::dic()->mainTemplate(), new ilTemplate(__DIR__ . "/../templates/tpl.piechart.html", true, true));

		return self::output()->getHTML($tpl);
	}
}
