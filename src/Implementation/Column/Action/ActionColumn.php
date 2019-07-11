<?php

namespace srag\DataTable\Implementation\Column\Action;

use srag\DataTable\Component\Column\Action\ActionColumn as ActionColumnInterface;
use srag\DataTable\Component\Column\Column as ColumnInterface;
use srag\DataTable\Implementation\Column\Column;

/**
 * Class ActionColumn
 *
 * @package srag\DataTable\Implementation\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ActionColumn extends Column implements ActionColumnInterface {

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
	public function withActions(array $actions): ColumnInterface {
		$clone = clone $this;

		$clone->actions = $actions;

		return $clone;
	}
}
