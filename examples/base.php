<?php

use srag\DataTable\Implementation\Factory;
use srag\DIC\DICStatic;

/**
 * @return string
 */
function base() : string
{
    $data = array_map(function (int $index) : stdClass {
        return (object) [
            "column1" => $index,
            "column2" => "text $index",
            "column3" => ($index % 2 === 0 ? "true" : "false")
        ];
    }, range(0, 25));

    DICStatic::dic()->ctrl()->saveParameterByClass(ilSystemStyleDocumentationGUI::class, "node_id");

    $action_url = DICStatic::dic()->ctrl()->getLinkTargetByClass(ilSystemStyleDocumentationGUI::class, "", "", false, false);

    $table = Factory::getInstance()->table("example_datatable_actions", $action_url, "Example data table", [
        Factory::getInstance()->column()->column("column1", "Column 1"),
        Factory::getInstance()->column()->column("column2", "Column 2"),
        Factory::getInstance()->column()->column("column3", "Column 3")
    ], Factory::getInstance()->data()->fetcher()->staticData($data, "column1"));

    return DICStatic::output()->getHTML($table);
}
