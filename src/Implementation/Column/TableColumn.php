<?php

namespace srag\TableUI\Implementation\Column;

use srag\TableUI\Component\Column\Formater\TableColumnFormater;
use srag\TableUI\Component\Column\TableColumn as TableColumnInterface;
use srag\TableUI\Component\Export\Formater\TableExportFormater;

/**
 * Class TableColumn
 *
 * @package srag\TableUI\Implementation\Column
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TableColumn implements TableColumnInterface {

	/**
	 * @var string
	 */
	protected $key = "";
	/**
	 * @var string
	 */
	protected $title = "";
	/**
	 * @var TableColumnFormater
	 */
	protected $format_value;
	/**
	 * @var TableExportFormater
	 */
	protected $format_export_value;
	/**
	 * @var bool
	 */
	protected $default = true;
	/**
	 * @var bool
	 */
	protected $sortable = true;
	/**
	 * @var bool
	 */
	protected $dragable = false;
	/**
	 * @var bool
	 */
	protected $selectable = true;


	/**
	 * TableColumn constructor
	 */
	public function __construct() {
	}


	/**
	 * @inheritDoc
	 */
	public function getKey(): string {
		return $this->key;
	}


	/**
	 * @inheritDoc
	 */
	public function withKey(string $key): TableColumnInterface {
		$clone = clone $this;

		$clone->key = $key;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getTitle(): string {
		return $this->title;
	}


	/**
	 * @inheritDoc
	 */
	public function withTitle(string $title): TableColumnInterface {
		$clone = clone $this;

		$clone->title = $title;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getFormatValue(): TableColumnFormater {
		return $this->format_value;
	}


	/**
	 * @inheritDoc
	 */
	public function withFormatValue(TableColumnFormater $format_value): TableColumnInterface {
		$clone = clone $this;

		$clone->format_value = $format_value;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getFormatExportValue(): TableExportFormater {
		return $this->format_export_value;
	}


	/**
	 * @inheritDoc
	 */
	public function withFormatExportValue(TableExportFormater $format_export_value): TableColumnInterface {
		$clone = clone $this;

		$clone->format_export_value = $format_export_value;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getDefault(): bool {
		return $this->default;
	}


	/**
	 * @inheritDoc
	 */
	public function withDefault(bool $default = true): TableColumnInterface {
		$clone = clone $this;

		$clone->default = $default;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getSortable(): bool {
		return $this->sortable;
	}


	/**
	 * @inheritDoc
	 */
	public function withSortable(bool $sortable = true): TableColumnInterface {
		$clone = clone $this;

		$clone->sortable = $sortable;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getDragable(): bool {
		return $this->dragable;
	}


	/**
	 * @inheritDoc
	 */
	public function withDragable(bool $dragable = false): TableColumnInterface {
		$clone = clone $this;

		$clone->dragable = $dragable;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getSelectable(): bool {
		return $this->selectable;
	}


	/**
	 * @inheritDoc
	 */
	public function withSelectable(bool $selectable = true): TableColumnInterface {
		$clone = clone $this;

		$clone->selectable = $selectable;

		return $clone;
	}
}
