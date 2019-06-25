<?php

namespace srag\TableUI\Component\Column\Action;

use srag\TableUI\Component\Column\TableColumn;

/**
 * Interface ActionTableColumn
 *
 * @package srag\TableUI\Component\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface ActionTableColumn extends TableColumn {

	/**
	 * @return string[]
	 */
	public function getActions(): array;


	/**
	 * @param string[] $actions
	 *
	 * @return TableColumn
	 */
	public function withActions(array $actions): TableColumn;
}
