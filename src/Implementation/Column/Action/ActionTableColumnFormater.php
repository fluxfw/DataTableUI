<?php

namespace srag\DataTable\Implementation\Column\Action;

use ILIAS\UI\Component\Button\Shy;
use ILIAS\UI\Renderer;
use ilUtil;
use srag\DataTable\Component\Column\Action\ActionTableColumn;
use srag\DataTable\Component\Column\TableColumn;
use srag\DataTable\Component\Data\Row\TableRowData;
use srag\DataTable\Component\DataTable;
use srag\DataTable\Implementation\Export\Formater\AbstractTableColumnFormater;

/**
 * Class ActionTableColumnFormater
 *
 * @package srag\DataTable\Implementation\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ActionTableColumnFormater extends AbstractTableColumnFormater {

	/**
	 * @inheritDoc
	 */
	public function formatHeader(TableColumn $column, Renderer $renderer): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 *
	 * @param ActionTableColumn $column
	 */
	public function formatRow(TableColumn $column, TableRowData $row, Renderer $renderer): string {
		return $renderer->render($this->dic->ui()->factory()->dropdown()
			->standard(array_map(function (string $title, string $action) use ($row): Shy {
				return $this->dic->ui()->factory()->button()->shy($title, ilUtil::appendUrlParameterString($action, DataTable::ACTION_GET_VAR . "="
					. $row->getRowId()));
			}, array_keys($column->getActions()), $column->getActions()))->withLabel($column->getTitle()));
	}
}
