<?php

use srag\DataTable\Component\Column\Column;
use srag\DataTable\Component\Data\Data;
use srag\DataTable\Component\Data\Row\RowData;
use srag\DataTable\Component\Format\Format;
use srag\DataTable\Component\Settings\Settings;
use srag\DataTable\Component\Settings\Sort\SortField;
use srag\DataTable\Implementation\Column\Formatter\Actions\AbstractActionsFormatter;
use srag\DataTable\Implementation\Column\Formatter\DefaultFormatter;
use srag\DataTable\Implementation\Data\Fetcher\AbstractDataFetcher;
use srag\DataTable\Implementation\Factory;
use srag\DIC\DICStatic;

/**
 * @return string
 */
function advanced() : string
{
    DICStatic::dic()->ctrl()->saveParameterByClass(ilSystemStyleDocumentationGUI::class, "node_id");

    $action_url = DICStatic::dic()->ctrl()->getLinkTargetByClass(ilSystemStyleDocumentationGUI::class, "", "", false, false);

    $table = Factory::getInstance()->table("example_datatable_advanced", $action_url, "Advanced example data table", [
        Factory::getInstance()->column()->column("obj_id", "Id")->withDefaultSelected(false),
        Factory::getInstance()->column()->column("title", "Title")->withFormatter(Factory::getInstance()->column()->formatter()->link())->withDefaultSort(true),
        Factory::getInstance()->column()->column("type", "Type")->withFormatter(Factory::getInstance()->column()->formatter()->languageVariable("obj")),
        Factory::getInstance()->column()->column("type_icon", "Type icon")->withFormatter(new AdvancedExampleFormatter()),
        Factory::getInstance()->column()->column("description", "Description")->withDefaultSelected(false)->withSortable(false),
        Factory::getInstance()->column()->column("actions", "Actions")->withFormatter(new AdvancedExampleActionsFormatter())
    ], new AdvancedExampleDataFetcher()
    )->withFilterFields([
        "title" => DICStatic::dic()->ui()->factory()->input()->field()->text("Title"),
        "type"  => DICStatic::dic()->ui()->factory()->input()->field()->text("Type")
    ])->withFormats([
        Factory::getInstance()->format()->csv(),
        Factory::getInstance()->format()->excel(),
        Factory::getInstance()->format()->pdf(),
        Factory::getInstance()->format()->html()
    ])->withMultipleActions([
        "Action" => $action_url
    ]);

    $info_text = DICStatic::dic()->ui()->factory()->legacy("");

    $action_row_id = $table->getBrowserFormat()->getActionRowId($table->getTableId());
    if ($action_row_id !== "") {
        $info_text = $info_text = DICStatic::dic()->ui()->factory()->messageBox()->info("Row id: " . $action_row_id);
    }

    $mutliple_action_row_ids = $table->getBrowserFormat()->getMultipleActionRowIds($table->getTableId());
    if (!empty($mutliple_action_row_ids)) {
        $info_text = DICStatic::dic()->ui()->factory()->messageBox()->info("Row ids: " . implode(", ", $mutliple_action_row_ids));
    }

    return DICStatic::output()->getHTML([$info_text, $table]);
}

/**
 * Class AdvancedExampleFormatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class AdvancedExampleFormatter extends DefaultFormatter
{

    /**
     * @inheritDoc
     */
    public function formatRowCell(Format $format, $value, Column $column, RowData $row, string $table_id) : string
    {
        $type = parent::formatRowCell($format, $value, $column, $row, $table_id);

        switch ($format->getFormatId()) {
            case Format::FORMAT_BROWSER:
            case Format::FORMAT_PDF:
            case Format::FORMAT_HTML:
                return self::output()->getHTML([
                    self::dic()->ui()->factory()->symbol()->icon()->custom(ilObject::_getIcon($row->getRowId(), "small"), $type),
                    self::dic()->ui()->factory()->legacy($type)
                ]);

            default:
                return $type;
        }
    }
}

/**
 * Class AdvancedExampleActionsFormatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class AdvancedExampleActionsFormatter extends AbstractActionsFormatter
{

    /**
     * @inheritDoc
     */
    public function getActions(RowData $row) : array
    {
        $action_url = self::dic()->ctrl()->getLinkTargetByClass(ilSystemStyleDocumentationGUI::class, "", "", false, false);

        return [
            self::dic()->ui()->factory()->link()->standard("Action", $action_url)
        ];
    }
}

/**
 * Class AdvancedExampleDataFetcher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class AdvancedExampleDataFetcher extends AbstractDataFetcher
{

    /**
     * @inheritDoc
     */
    public function fetchData(Settings $settings) : Data
    {
        $sql = 'SELECT *' . $this->getQuery($settings);

        $result = self::dic()->database()->query($sql);

        $rows = [];
        while (!empty($row = self::dic()->database()->fetchObject($result))) {
            $row->type_icon = $row->type;

            $row->title_link = ilLink::_getLink(current(ilObject::_getAllReferences($row->obj_id)));

            $rows[] = self::dataTable()->data()->row()->property(strval($row->obj_id), $row);
        }

        $sql = 'SELECT COUNT(obj_id) AS count' . $this->getQuery($settings, true);

        $result = self::dic()->database()->query($sql);

        $max_count = intval($result->fetchAssoc()["count"]);

        return self::dataTable()->data()->data($rows, $max_count);
    }


    /**
     * @param Settings $settings
     * @param bool     $max_count
     *
     * @return string
     */
    protected function getQuery(Settings $settings, bool $max_count = false) : string
    {
        $sql = ' FROM object_data';

        $field_values = array_filter($settings->getFilterFieldValues());

        if (!empty($field_values)) {
            $sql .= ' WHERE ' . implode(' AND ', array_map(function (string $key, string $value) : string {
                    return self::dic()->database()->like($key, ilDBConstants::T_TEXT, '%' . $value . '%');
                }, array_keys($field_values), $field_values));
        }

        if (!$max_count) {
            if (!empty($settings->getSortFields())) {
                $sql .= ' ORDER BY ' . implode(", ", array_map(function (SortField $sort_field) : string {
                        return self::dic()->database()->quoteIdentifier($sort_field->getSortField()) . ' ' . ($sort_field->getSortFieldDirection()
                            === SortField::SORT_DIRECTION_DOWN ? 'DESC' : 'ASC');
                    }, $settings->getSortFields()));
            }

            if (!empty($settings->getOffset()) && !empty($settings->getRowsCount())) {
                self::dic()->database()->setLimit($settings->getRowsCount(), $settings->getOffset());
            }
        }

        return $sql;
    }
}
