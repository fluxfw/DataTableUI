<?php

namespace srag\DataTable\Component\Column;

use srag\DataTable\Component\Column\Formater\Formater;
use srag\DataTable\Component\Filter\Sort\FilterSortField;

/**
 * Interface Column
 *
 * @package srag\DataTable\Component\Column
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface Column {

	/**
	 * Column constructor
	 *
	 * @param string $key
	 * @param string $title
	 */
	public function __construct(string $key, string $title);


	/**
	 * @return string
	 */
	public function getKey(): string;


	/**
	 * @param string $key
	 *
	 * @return self
	 */
	public function withKey(string $key): self;


	/**
	 * @return string
	 */
	public function getTitle(): string;


	/**
	 * @param string $title
	 *
	 * @return self
	 */
	public function withTitle(string $title): self;


	/**
	 * @return Formater
	 */
	public function getFormater(): Formater;


	/**
	 * @param Formater $formater
	 *
	 * @return self
	 */
	public function withFormater(Formater $formater): self;


	/**
	 * @return bool
	 */
	public function isSortable(): bool;


	/**
	 * @param bool $sortable
	 *
	 * @return self
	 */
	public function withSortable(bool $sortable = true): self;


	/**
	 * @return bool
	 */
	public function isDefaultSort(): bool;


	/**
	 * @param bool $default_sort
	 *
	 * @return self
	 */
	public function withDefaultSort(bool $default_sort = false): self;


	/**
	 * @return int
	 */
	public function getDefaultSortDirection(): int;


	/**
	 * @param int $default_sort_direction
	 *
	 * @return self
	 */
	public function withDefaultSortDirection(int $default_sort_direction = FilterSortField::SORT_DIRECTION_UP): self;


	/**
	 * @return bool
	 */
	public function isSelectable(): bool;


	/**
	 * @param bool $selectable
	 *
	 * @return self
	 */
	public function withSelectable(bool $selectable = true): self;


	/**
	 * @return bool
	 */
	public function isDefaultSelected(): bool;


	/**
	 * @param bool $default_selected
	 *
	 * @return self
	 */
	public function withDefaultSelected(bool $default_selected = true): self;


	/**
	 * @return bool
	 */
	public function isExportable(): bool;


	/**
	 * @param bool $exportable
	 *
	 * @return self
	 */
	public function withExportable(bool $exportable = true): self;


	/**
	 * @return bool
	 */
	public function isDragable(): bool;


	/**
	 * @param bool $dragable
	 *
	 * @return self
	 */
	public function withDragable(bool $dragable = false): self;
}