<?php

namespace srag\TableUI\Implementation\Column\Action;

use srag\TableUI\Component\Column\Action\ActionTableColumn as ActionTableColumnInterface;
use srag\TableUI\Component\Column\TableColumn as TableColumnInterface;
use srag\TableUI\Implementation\Column\TableColumn;

/**
 * Class ActionTableColumn
 *
 * @package srag\TableUI\Implementation\Column\Action
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
