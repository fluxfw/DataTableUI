<?php

namespace srag\TableUI\Implementation;

use ILIAS\UI\Component\Input\Field\FilterInput;
use ILIAS\UI\Implementation\Component\ComponentHelper;
use srag\TableUI\Component\Column\TableColumn;
use srag\TableUI\Component\Data\Fetcher\TableDataFetcher;
use srag\TableUI\Component\Export\TableExportFormat;
use srag\TableUI\Component\Filter\Storage\TableFilterStorage;
use srag\TableUI\Component\Filter\TableFilter;
use srag\TableUI\Component\Table as TableInterface;

/**
 * Class Table
 *
 * @package srag\TableUI\Implementation
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class Table implements TableInterface {

	use ComponentHelper;
	/**
	 * @var string
	 */
	protected $id = "";
	/**
	 * @var string
	 */
	protected $action_url = "";
	/**
	 * @var string
	 */
	protected $title = "";
	/**
	 * @var bool
	 */
	protected $fetch_data_needs_filter_first_set = false;
	/**
	 * @var int
	 */
	protected $filter_position = TableFilter::FILTER_POSITION_TOP;
	/**
	 * @var TableColumn[]
	 */
	protected $columns = [];
	/**
	 * @var TableDataFetcher
	 */
	protected $data_fetcher;
	/**
	 * @var FilterInput[]
	 */
	protected $filter_fields = [];
	/**
	 * @var TableExportFormat[]
	 */
	protected $export_formats = [];
	/**
	 * @var string[]
	 */
	protected $multiple_actions = [];
	/**
	 * @var TableFilterStorage|null
	 */
	protected $filter_storage = null;


	/**
	 * @inheritDoc
	 */
	public function __construct(string $id, string $action_url, string $title, array $columns, TableDataFetcher $data_fetcher) {
		$this->id = $id;

		$this->action_url = $action_url;

		$this->title = $title;

		$this->columns = $columns;

		$this->data_fetcher = $data_fetcher;
	}


	/**
	 * @inheritDoc
	 */
	public function getId(): string {
		return $this->id;
	}


	/**
	 * @inheritDoc
	 */
	public function withId(string $id): TableInterface {
		$clone = clone $this;

		$clone->id = $id;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getActionUrl(): string {
		return $this->action_url;
	}


	/**
	 * @inheritDoc
	 */
	public function withActionUrl(string $action_url): TableInterface {
		$clone = clone $this;

		$clone->action_url = $action_url;

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
	public function withTitle(string $title): TableInterface {
		$clone = clone $this;

		$clone->title = $title;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function isFetchDataNeedsFilterFirstSet(): bool {
		return $this->fetch_data_needs_filter_first_set;
	}


	/**
	 * @inheritDoc
	 */
	public function withFetchDataNeedsFilterFirstSet(bool $fetch_data_needs_filter_first_set = false): TableInterface {
		$clone = clone $this;

		$clone->fetch_data_needs_filter_first_set = $fetch_data_needs_filter_first_set;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getFilterPosition(): int {
		return $this->filter_position;
	}


	/**
	 * @inheritDoc
	 */
	public function withFilterPosition(int $filter_position = TableFilter::FILTER_POSITION_TOP): TableInterface {
		$clone = clone $this;

		$clone->filter_position = $filter_position;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getColumns(): array {
		return $this->columns;
	}


	/**
	 * @inheritDoc
	 */
	public function withColumns(array $columns): TableInterface {
		$clone = clone $this;

		$clone->columns = $columns;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getDataFetcher(): TableDataFetcher {
		return $this->data_fetcher;
	}


	/**
	 * @inheritDoc
	 */
	public function withFetchData(TableDataFetcher $data_fetcher): TableInterface {
		$clone = clone $this;

		$clone->data_fetcher = $data_fetcher;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getFilterFields(): array {
		return $this->filter_fields;
	}


	/**
	 * @inheritDoc
	 */
	public function withFilterFields(array $filter_fields): TableInterface {
		$clone = clone $this;

		$clone->filter_fields = $filter_fields;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getExportFormats(): array {
		return $this->export_formats;
	}


	/**
	 * @inheritDoc
	 */
	public function withExportFormats(array $export_formats): TableInterface {
		$clone = clone $this;

		$clone->export_formats = $export_formats;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getMultipleActions(): array {
		return $this->multiple_actions;
	}


	/**
	 * @inheritDoc
	 */
	public function withMultipleActions(array $multiple_actions): TableInterface {
		$clone = clone $this;

		$clone->multiple_actions = $multiple_actions;

		return $clone;
	}


	/**
	 * @inheritDoc
	 */
	public function getFilterStorage(): ?TableFilterStorage {
		return $this->filter_storage;
	}


	/**
	 * @inheritDoc
	 */
	public function withFilterStorage(?TableFilterStorage $filter_storage): TableInterface {
		$clone = clone $this;

		$clone->filter_storage = $filter_storage;

		return $clone;
	}
}
