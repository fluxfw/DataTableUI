<?php

namespace srag\TableUI\Component;

use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Input\Field\Input;
use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Fetcher\TableDataFetcher;
use srag\TableUI\Component\Export\TableExportFormat;
use srag\TableUI\Component\Filter\TableFilter;

/**
 * Interface TableUI
 *
 * @package srag\TableUI\Component
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableUI extends Component {

	/**
	 * TableUI constructor
	 */
	public function __construct();


	/**
	 * @return string
	 */
	public function getId(): string;


	/**
	 * @param string $id
	 *
	 * @return self
	 */
	public function withId(string $id): self;


	/**
	 * @return string
	 */
	public function getAction(): string;


	/**
	 * @param string $action
	 *
	 * @return self
	 */
	public function withAction(string $action): self;


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
	 * @return bool
	 */
	public function getFetchDataNeedsFilterFirstSet(): bool;


	/**
	 * @param bool $fetch_data_needs_filter_first_set
	 *
	 * @return self
	 */
	public function withFetchDataNeedsFilterFirstSet(bool $fetch_data_needs_filter_first_set = false): self;


	/**
	 * @return int
	 */
	public function getFilterPosition(): int;


	/**
	 * @param int $filter_position
	 *
	 * @return self
	 */
	public function withFilterPosition(int $filter_position = TableFilter::FILTER_TOP): self;


	/**
	 * @return TableColumn[]
	 */
	public function getColumns(): array;


	/**
	 * @param TableColumn[] $columns
	 *
	 * @return self
	 */
	public function withColumns(array $columns): self;


	/**
	 * @return TableDataFetcher
	 */
	public function getDataFetcher(): TableDataFetcher;


	/**
	 * @param TableDataFetcher $data_fetcher
	 *
	 * @return self
	 */
	public function withFetchData(TableDataFetcher $data_fetcher): self;


	/**
	 * @return Input[]
	 */
	public function getFilterFields(): array;


	/**
	 * @param Input[] $filter_fields
	 *
	 * @return self
	 */
	public function withFilterFields(array $filter_fields): self;


	/**
	 * @return TableExportFormat[]
	 */
	public function getExportFormats(): array;


	/**
	 * @param TableExportFormat[] $export_formats
	 *
	 * @return self
	 */
	public function withExportFormats(array $export_formats): self;


	/**
	 * @return string[]
	 */
	public function getMultipleActions(): array;


	/**
	 * @param string[] $multiple_actions
	 *
	 * @return self
	 */
	public function withMultipleActions(array $multiple_actions): self;


	/**
	 * @return bool
	 */
	public function getSelectAll(): bool;


	/**
	 * @param bool $select_all
	 *
	 * @return self
	 */
	public function withSelectAll(bool $select_all = false): self;
}
