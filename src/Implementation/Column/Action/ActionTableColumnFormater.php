<?php

namespace srag\TableUI\Implementation\Column\Action;

use ILIAS\UI\Component\Button\Shy;
use ilUtil;
use srag\DIC\DICTrait;
use srag\TableUI\Component\Column\Action\ActionTableColumn;
use srag\TableUI\Component\Column\Formater\TableColumnFormater;
use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Row\TableRowData;
use srag\TableUI\Component\Table;

/**
 * Class ActionTableColumnFormater
 *
 * @package srag\TableUI\Implementation\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ActionTableColumnFormater implements TableColumnFormater {

	use DICTrait;


	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableColumn $column): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 *
	 * @param ActionTableColumn $column
	 */
	public function formatRow(TableColumn $column, TableRowData $row): string {
		return self::dic()->ui()->renderer()->render(self::dic()->ui()->factory()->dropdown()
			->standard(array_map(function (string $title, string $action) use ($row): Shy {
				return self::dic()->ui()->factory()->button()->shy($title, ilUtil::appendUrlParameterString($action, Table::ACTION_GET_VAR . "="
					. $row->getRowId()));
			}, array_keys($column->getActions()), $column->getActions()))->withLabel($column->getTitle()));
	}
}
