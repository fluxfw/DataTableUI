<?php

namespace srag\DataTable\Implementation\Column\Action;

use srag\DataTable\Component\Column\Action\ActionTableColumn as ActionTableColumnInterface;
use srag\DataTable\Component\Column\TableColumn as TableColumnInterface;
use srag\DataTable\Implementation\Column\TableColumn;

/**
 * Class ActionTableColumn
 *
 * @package srag\DataTable\Implementation\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ActionTableColumn extends TableColumn implements ActionTableColumnInterface {

	/**
	 * @var string[]
	 */
	protected $actions = [];


	/**
	 * @inheritDoc
	 */
	public function getActions(): array {
		return $this->actions;
	}


	/**
	 * @inheritDoc
	 */
	public function withActions(array $actions): TableColumnInterface {
		$clone = clone $this;

		$clone->actions = $actions;

		return $clone;
	}
}
