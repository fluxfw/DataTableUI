<?php

namespace srag\DataTable\Component\Format;

use srag\DataTable\Component\Filter\Filter;
use srag\DataTable\Component\Table;

/**
 * Interface BrowserFormat
 *
 * @package srag\DataTable\Component\Format
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface BrowserFormat extends Format {

	/**
	 * @param Table $component
	 *
	 * @return string|null
	 */
	public function getInputFormatId(Table $component): ?string;


	/**
	 * @param Table  $component
	 * @param Filter $filter
	 *
	 * @return Filter
	 */
	public function handleFilterInput(Table $component, Filter $filter): Filter;
}
