<?php

namespace ILIAS\UI\Implementation\Table\Data\Column\Action;

use ILIAS\DI\Container;
use ILIAS\UI\Component\Button\Shy;
use ILIAS\UI\Component\Table\Data\Column\Action\ActionTableColumn;
use ILIAS\UI\Component\Table\Data\Column\Formater\TableColumnFormater;
use ILIAS\UI\Component\Table\Data\Column\TableColumn;
use ILIAS\UI\Component\Table\Data\Data\Row\TableRowData;
use ILIAS\UI\Component\Table\Data\DataTable;
use ILIAS\UI\Renderer;
use ilUtil;

/**
 * Class ActionTableColumnFormater
 *
 * @package ILIAS\UI\Implementation\Table\Data\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ActionTableColumnFormater implements TableColumnFormater {

	/**
	 * @inheritDoc
	 */
	public function __construct() {

	}


	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableColumn $column, Renderer $renderer, Container $dic): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 *
	 * @param ActionTableColumn $column
	 */
	public function formatRow(TableColumn $column, TableRowData $row, Renderer $renderer, Container $dic): string {
		return $renderer->render($dic->ui()->factory()->dropdown()
			->standard(array_map(function (string $title, string $action) use ($row, $dic): Shy {
				return $dic->ui()->factory()->button()->shy($title, ilUtil::appendUrlParameterString($action, DataTable::ACTION_GET_VAR . "="
					. $row->getRowId()));
			}, array_keys($column->getActions()), $column->getActions()))->withLabel($column->getTitle()));
	}
}
