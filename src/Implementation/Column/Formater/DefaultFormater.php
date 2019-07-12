<?php

namespace srag\DataTable\Implementation\Column\Formater;

use ilExcel;
use ILIAS\UI\Renderer;
use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Format\Format;

/**
 * Class DefaultFormater
 *
 * @package srag\DataTable\Implementation\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class DefaultFormater extends AbstractFormater {

	/**
	 * @inheritDoc
	 */
	public function formatHeader(Format $format, Column $column, string $table_id, Renderer $renderer): string {
		$title = $column->getTitle();

		switch ($format->getFormatId()) {
			case Format::FORMAT_PDF:
				return "<b>{$title}</b>";

			case Format::FORMAT_EXCEL:
				/**
				 * @var ilExcel $tpl
				 */ $tpl = $format->getTemplate()->tpl;
				$cord = $tpl->getColumnCoord($format->getTemplate()->current_col) . $format->getTemplate()->current_col;
				$tpl->setBold($cord . ":" . $cord);

				return $title;

			default:
				return $title;
		}
	}


	/**
	 * @inheritDoc
	 */
	public function formatRow(Format $format, Column $column, RowData $row, string $table_id, Renderer $renderer): string {
		$value = $row($column->getKey());

		$value = strval($value);

		switch ($format->getFormatId()) {
			case Format::FORMAT_BROWSER:
				if ($value === "") {
					$value = "&nbsp;";
				}

				return $value;

			default:
				return $value;
		}
	}
}
