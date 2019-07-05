<?php

namespace ILIAS\UI\Implementation\Table\Data\Export;

use ilHtmlToPdfTransformerFactory;
use ILIAS\UI\Component\Table\Data\DataTable;
use ILIAS\UI\Renderer;
use ilTemplate;

/**
 * Class TablePDFExportFormat
 *
 * @package ILIAS\UI\Implementation\Table\Data\Export
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class TablePDFTableExportFormat extends AbstractTableExportFormat {

	/**
	 * @inheritDoc
	 */
	public function getId(): int {
		return self::EXPORT_FORMAT_PDF;
	}


	/**
	 * @inheritDoc
	 */
	public function getTitle(): string {
		return $this->dic->language()->txt(DataTable::LANG_MODULE . "_export_pdf");
	}


	/**
	 * @inheritDoc
	 */
	public function export(array $columns, array $rows, string $title, Renderer $renderer): void {
		$css = file_get_contents(__DIR__ . "/../../../css/pdf_export.css");

		$tpl = new ilTemplate(__DIR__ . "/../../../templates/pdf_export.html", true, true); // TODO: Somehow access `getTemplate` of renderer

		$tpl->setVariable("CSS", $css);

		$tpl->setCurrentBlock("header");
		foreach ($columns as $column) {
			$tpl->setVariable("HEADER", $column);

			$tpl->parseCurrentBlock();
		}

		$tpl->setCurrentBlock("body");
		foreach ($rows as $row) {
			$tpl_row = new ilTemplate(__DIR__ . "/../../../templates/row.html", true, true); // TODO: Somehow access `getTemplate` of renderer

			$tpl_row->setCurrentBlock("row");

			foreach ($row as $column) {
				$tpl_row->setVariable("COLUMN", $column);

				$tpl_row->parseCurrentBlock();
			}

			$tpl->setVariable("ROW", $tpl_row->get());

			$tpl->parseCurrentBlock();
		}

		$html = $tpl->get();

		$filename = $title . ".pdf";

		$a = new ilHtmlToPdfTransformerFactory();

		$a->deliverPDFFromHTMLString($html, $filename, ilHtmlToPdfTransformerFactory::PDF_OUTPUT_DOWNLOAD, self::class, "");
	}
}
