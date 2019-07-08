<?php

namespace srag\DataTable\Component;

use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Input\Field\FilterInput;
use srag\DataTable\Component\Column\TableColumn;
use srag\DataTable\Component\Data\Fetcher\TableDataFetcher;
use srag\DataTable\Component\Export\TableExportFormat;
use srag\DataTable\Component\Factory\Factory;
use srag\DataTable\Component\Filter\Storage\TableFilterStorage;
use srag\DataTable\Component\Filter\TableFilter;

/**
 * Interface DataTable
 *
 * @package srag\DataTable\Component
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface DataTable extends Component {

	const ACTION_GET_VAR = "row_id";
	const MULTIPLE_SELECT_POST_VAR = "selected_row_ids";
	const LANG_MODULE = "datatable";


	/**
	 * DataTable constructor
	 *
	 * @param string             $id
	 * @param string             $action_url
	 * @param string             $title
	 * @param TableColumn[]      $columns
	 * @param TableDataFetcher   $data_fetcher
	 * @param TableFilterStorage $filter_storage
	 * @param Factory            $factory
	 */
	public function __construct(string $id, string $action_url, string $title, array $columns, TableDataFetcher $data_fetcher, TableFilterStorage $filter_storage, Factory $factory);


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
	public function getActionUrl(): string;


	/**
	 * @param string $action_url
	 *
	 * @return self
	 */
	public function withActionUrl(string $action_url): self;


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
	public function isFetchDataNeedsFilterFirstSet(): bool;


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
	public function withFilterPosition(int $filter_position = TableFilter::FILTER_POSITION_TOP): self;


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
	 * @return FilterInput[]
	 */
	public function getFilterFields(): array;


	/**
	 * @param FilterInput[] $filter_fields
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
	 * @return TableFilterStorage
	 */
	public function getFilterStorage(): TableFilterStorage;


	/**
	 * @param TableFilterStorage $filter_storage
	 *
	 * @return self
	 */
	public function withFilterStorage(TableFilterStorage $filter_storage): self;


	/**
	 * @return Factory
	 */
	public function getFactory(): Factory;
}
