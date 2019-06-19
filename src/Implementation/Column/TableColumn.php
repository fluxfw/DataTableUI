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
	protected $column_formater;
	/**
	 * @var TableExportFormater
	 */
	protected $export_formater;
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
	 * @inheritDoc
	 */
	public function __construct(string $key, string $title, TableColumnFormater $column_formater, TableExportFormater $export_formater) {
		$this->key = $key;
		$this->title = $title;
		$this->column_formater = $column_formater;
		$this->export_formater = $export_formater;
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
	public function getColumnFormater(): TableColumnFormater {
		return $this->column_formater;
	}


	/**
	 * @inheritDoc
	 */
	public function withColumnFormater(TableColumnFormater $column_formater): TableColumnInterface {
		$clone = clone $this;

		$clone->column_formater = $column_formater;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getExportFormater(): TableExportFormater {
		return $this->export_formater;
	}


	/**
	 * @inheritDoc
	 */
	public function withExportFormater(TableExportFormater $export_formater): TableColumnInterface {
		$clone = clone $this;

		$clone->export_formater = $export_formater;

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
