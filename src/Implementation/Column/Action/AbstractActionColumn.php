<?php

namespace srag\DataTable\Implementation\Column\Action;

use ILIAS\DI\Container;
use srag\DataTable\Component\Column\Action\ActionColumn as ActionColumnInterface;
use srag\DataTable\Implementation\Column\Column;

/**
 * Class AbstractActionColumn
 *
 * @package srag\DataTable\Implementation\Column\Action
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
abstract class AbstractActionColumn extends Column implements ActionColumnInterface
{

    /**
     * @inheritDoc
     */
    protected $sortable = false;
    /**
     * @inheritDoc
     */
    protected $selectable = false;
    /**
     * @inheritDoc
     */
    protected $exportable = false;


    /**
     * AbstractActionColumn constructor
     *
     * @param Container $dic
     * @param string    $key
     * @param string    $title
     */
    public function __construct(Container $dic, string $key, string $title)
    {
        parent::__construct($dic, $key, $title);

        $this->formater = new ActionFormater($this->dic);
    }
}
