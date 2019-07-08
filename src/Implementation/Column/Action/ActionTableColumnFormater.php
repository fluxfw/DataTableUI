<?php

namespace srag\DataTable\Implementation\Column\Action;

use ILIAS\UI\Component\Button\Shy;
use ILIAS\UI\Renderer as RendererInterface;
use srag\DataTable\Component\Column\Action\ActionTableColumn;
use srag\DataTable\Component\Column\TableColumn;
use srag\DataTable\Component\Data\Row\TableRowData;
use srag\DataTable\Component\DataTable;
use srag\DataTable\Implementation\Export\Formater\AbstractTableColumnFormater;
use srag\DataTable\Implementation\Renderer;

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
	public function formatHeader(TableColumn $column, string $table_id, RendererInterface $renderer): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 *
	 * @param ActionTableColumn $column
	 */
	public function formatRow(TableColumn $column, TableRowData $row, string $table_id, RendererInterface $renderer): string {
		return $renderer->render($this->dic->ui()->factory()->dropdown()
			->standard(array_map(function (string $title, string $action) use ($row, $table_id): Shy {
				return $this->dic->ui()->factory()->button()
					->shy($title, Renderer::getActionUrl($action, [ DataTable::ACTION_GET_VAR => $row->getRowId() ], $table_id));
			}, array_keys($column->getActions()), $column->getActions()))->withLabel($column->getTitle()));
	}
}
