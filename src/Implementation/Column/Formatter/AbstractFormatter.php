<?php

namespace srag\DataTableUI\Implementation\Column\Formatter;

use srag\DataTableUI\Component\Column\Formatter\Formatter;
use srag\DataTableUI\Implementation\Utils\DataTableUITrait;
use srag\DIC\DICTrait;

/**
 * Class AbstractFormatter
 *
 * @package srag\DataTableUI\Implementation\Column\Formatter
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractFormatter implements Formatter
{

    use DICTrait;
    use DataTableUITrait;

    /**
     * AbstractFormatter constructor
     */
    public function __construct()
    {

    }
}
