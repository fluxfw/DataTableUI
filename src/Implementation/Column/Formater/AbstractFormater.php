<?php

namespace srag\DataTable\Implementation\Column\Formater;

use ILIAS\DI\Container;
use srag\DataTable\Component\Column\Formater\Formater;

/**
 * Class AbstractFormater
 *
 * @package srag\DataTable\Implementation\Column\Formater
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractFormater implements Formater
{

    /**
     * @var Container
     */
    protected $dic;


    /**
     * @inheritDoc
     */
    public function __construct(Container $dic)
    {
        $this->dic = $dic;
    }
}
