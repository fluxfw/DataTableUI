<?php

namespace srag\DataTable\Implementation\Column\Formatter;

use srag\DataTable\Component\Column\Formatter\Formatter;
use srag\DataTable\Utils\DataTableTrait;
use srag\DIC\DICTrait;

/**
 * Class AbstractFormatter
 *
 * @package srag\DataTable\Implementation\Column\Formatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractFormatter implements Formatter
{

    use DICTrait;
    use DataTableTrait;


    /**
     * AbstractFormatter constructor
     */
    public function __construct()
    {

    }
}
