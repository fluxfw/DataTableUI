<?php

use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Data\Data as DataInterface;
use srag\DataTable\Component\Factory\Factory as FactoryInterface;
use srag\DataTable\Component\Filter\Sort\FilterSortField;
use srag\DataTable\Component\Filter\Filter;
use srag\DataTable\Example\Column\Formater\SimplePropertyColumnFormater;
use srag\DataTable\Example\Column\Formater\SimplePropertyExportFormater;
use srag\DataTable\Example\Filter\Storage\TableFilterStorage;
use srag\DataTable\Implementation\Data\Fetcher\AbstractDataFetcher;
use srag\DataTable\Implementation\Data\Data;
use srag\DataTable\Implementation\Export\Formater\AbstractColumnFormater;
use srag\DataTable\Implementation\Factory\Factory;
use ILIAS\UI\Renderer;

/**
 * @return string
 */
function advanced(): string {
	global $DIC;

	$action_url = $DIC->ctrl()->getLinkTargetByClass(ilSystemStyleDocumentationGUI::class) . "&node_id=TableDataData";

	$factory = new Factory($DIC); // TODO: Later from `$DIC->ui()->factory()->table()->data()`

	$table = $factory->table("example_datatable_advanced", $action_url, "Advanced example data table", [
		$factory->column("obj_id", "Id", new SimplePropertyColumnFormater($DIC), new SimplePropertyExportFormater($DIC))
			->withDefaultSelected(false),
		$factory->column("title", "Title", new SimplePropertyColumnFormater($DIC), new SimplePropertyExportFormater($DIC))
			->withDefaultSort(true),
		$factory->column("type", "Type", new class($DIC) extends AbstractColumnFormater {

			/**
			 * @inheritDoc
			 */
			public function formatHeader(Column $column, string $table_id, Renderer $renderer): string {
				return $column->getTitle();
			}


			/**
			 * @inheritDoc
			 */
			public function formatRow(Column $column, RowData $row, string $table_id, Renderer $renderer): string {
				$type = $row->getOriginalData()->{$column->getKey()};

				return $renderer->render([
					$this->dic->ui()->factory()->symbol()->icon()->custom(ilObject::_getIcon($row->getRowId(), "small"), $type),
					$this->dic->ui()->factory()->legacy($type)
				]);
			}
		}, new SimplePropertyExportFormater($DIC)),
		$factory->column("description", "Description", new SimplePropertyColumnFormater($DIC), new SimplePropertyExportFormater($DIC))
			->withDefaultSelected(false)->withSortable(false),
		$factory->actionColumn("actions", "Actions", [
			"Action" => $action_url
		])
	], new class($DIC) extends AbstractDataFetcher {

		/**
		 * @inheritDoc
		 */
		public function fetchData(Filter $filter, FactoryInterface $factory): DataInterface {
			$sql = 'SELECT *' . $this->getQuery($filter);

			$result = $this->dic->database()->query($sql);

			$rows = [];
			while (!empty($row = $this->dic->database()->fetchAssoc($result))) {
				$rows[] = $factory->rowData($row["obj_id"], (object)$row);
			}

			$sql = 'SELECT COUNT(obj_id) AS count' . $this->getQuery($filter, true);

			$result = $this->dic->database()->query($sql);

			$max_count = intval($result->fetchAssoc()["count"]);

			return new Data($rows, $max_count);
		}


		/**
		 * @param Filter $filter
		 * @param bool   $max_count
		 *
		 * @return string
		 */
		protected function getQuery(Filter $filter, $max_count = false): string {
			$sql = ' FROM object_data';

			$field_values = array_filter($filter->getFieldValues());

			if (!empty($field_values)) {
				$sql .= ' WHERE ' . implode(' AND ', array_map(function (string $key, string $value): string {
						return $this->dic->database()->like($key, ilDBConstants::T_TEXT, '%' . $value . '%');
					}, array_keys($field_values), $field_values));
			}

			if (!$max_count) {
				if (!empty($filter->getSortFields())) {
					$sql .= ' ORDER BY ' . implode(", ", array_map(function (FilterSortField $sort_field): string {
							return $this->dic->database()->quoteIdentifier($sort_field->getSortField()) . ' ' . ($sort_field->getSortFieldDirection()
								=== FilterSortField::SORT_DIRECTION_DOWN ? 'DESC' : 'ASC');
						}, $filter->getSortFields()));
				}

				if (!empty($filter->getLimitStart()) && !empty($filter->getLimitEnd())) {
					$sql .= ' LIMIT ' . $this->dic->database()->quote($filter->getLimitStart(), ilDBConstants::T_INTEGER) . ','
						. $this->dic->database()->quote($filter->getLimitEnd(), ilDBConstants::T_INTEGER);
				}
			}

			return $sql;
		}
	}, new TableFilterStorage($DIC))->withFilterFields([
		"title" => $DIC->ui()->factory()->input()->field()->text("Title"),
		"type" => $DIC->ui()->factory()->input()->field()->text("Type")
	])->withExportFormats([
		$factory->exportFormatCSV(),
		$factory->exportFormatExcel(),
		$factory->exportFormatPDF()
	])->withMultipleActions([
		"Action" => $action_url
	]);

	$info_text = $DIC->ui()->factory()->legacy("");

	$action_row_id = $table->getActionRowId();
	if ($action_row_id !== "") {
		$info_text = $info_text = $DIC->ui()->factory()->messageBox()->info("Row id: " . $action_row_id);
	}

	$mutliple_action_row_ids = $table->getMultipleActionRowIds();
	if (!empty($mutliple_action_row_ids)) {
		$info_text = $DIC->ui()->factory()->messageBox()->info("Row ids: " . implode(", ", $mutliple_action_row_ids));
	}

	return $DIC->ui()->renderer()->render([ $info_text, $table ]);
}
