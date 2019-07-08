<?php

namespace srag\DataTable\Component\Column\Action;

use srag\DataTable\Component\Column\TableColumn;

/**
 * Interface ActionTableColumn
 *
 * @package srag\DataTable\Component\Column\Action
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
