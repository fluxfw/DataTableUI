<?php

namespace srag\DataTable\Implementation\Column\Action;

use srag\DataTable\Component\Column\Action\ActionColumn as ActionColumnInterface;
use srag\DataTable\Implementation\Column\Column;

/**
 * Class AbstractActionColumn
 *
 * @package srag\DataTable\Implementation\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractActionColumn extends Column implements ActionColumnInterface {

	/**
	 * @inheritDoc
	 */
	protected $sortable = false;
	/**
	 * @inheritDoc
	 */
	protected $selectable = false;
	/**
	 * @inheritDoc
	 */
	protected $exportable = false;


	/**
	 * @inheritDoc
	 */
	public function __construct(string $key, string $title) {
		parent::__construct($key, $title);

		global $DIC; // TODO: !!!
		$this->formater = new ActionFormater($DIC);
	}
}
