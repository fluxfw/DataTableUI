<?php

namespace srag\TableUI\Component\Filter\Storage;

use srag\TableUI\Component\Filter\TableFilter as TableFilterInterface;

/**
 * Interface TableFilterStorage
 *
 * @package srag\TableUI\Component\Filter\Storage
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
interface TableFilterStorage {

	/**
	 * TableFilterStorage constructor
	 */
	public function __construct();


	/**
	 * @param string $table_id
	 * @param int    $user_id
	 *
	 * @return TableFilterInterface
	 */
	public function read(string $table_id, int $user_id): TableFilterInterface;


	/**
	 * @param TableFilterInterface $filter
	 */
	public function store(TableFilterInterface $filter): void;
}
