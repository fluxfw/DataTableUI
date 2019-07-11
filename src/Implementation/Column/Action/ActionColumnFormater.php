<?php

namespace srag\DataTable\Implementation\Column\Action;

use ILIAS\UI\Component\Button\Shy;
use ILIAS\UI\Renderer as RendererInterface;
use srag\DataTable\Component\Column\Action\ActionColumn;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Table;
use srag\DataTable\Implementation\Export\Formater\AbstractColumnFormater;
use srag\DataTable\Implementation\Renderer;

/**
 * Class ActionColumnFormater
 *
 * @package srag\DataTable\Implementation\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ActionColumnFormater extends AbstractColumnFormater {

	/**
	 * @inheritDoc
	 */
	public function formatHeader(Column $column, string $table_id, RendererInterface $renderer): string {
		return $column->getTitle();
	}


	/**
	 * @inheritDoc
	 *
	 * @param ActionColumn $column
	 */
	public function formatRow(Column $column, RowData $row, string $table_id, RendererInterface $renderer): string {
		return $renderer->render($this->dic->ui()->factory()->dropdown()
			->standard(array_map(function (string $title, string $action) use ($row, $table_id): Shy {
				return $this->dic->ui()->factory()->button()
					->shy($title, Renderer::getActionUrl($action, [ Table::ACTION_GET_VAR => $row->getRowId() ], $table_id));
			}, array_keys($column->getActions()), $column->getActions()))->withLabel($column->getTitle()));
	}
}
