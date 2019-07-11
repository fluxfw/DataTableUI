<?php

namespace srag\DataTable\Implementation\Export;

use ILIAS\DI\Container;
use srag\DataTable\Component\Export\ExportFormat;

/**
 * Class AbstractExportFormat
 *
 * @package srag\DataTable\Implementation\Export
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractExportFormat implements ExportFormat {

	/**
	 * @var Container
	 */
	protected $dic;


	/**
	 * @inheritDoc
	 */
	public function __construct(Container $dic) {
		$this->dic = $dic;
	}
}
