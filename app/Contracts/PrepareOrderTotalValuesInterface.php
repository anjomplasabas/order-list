<?php

namespace App\Contracts;

interface PrepareOrderTotalValuesInterface
{

	/**
	 * Set order json object
	 *
	 * @param object $order
	 */
	public function setOrder($order);

	/**
	 * Get total value of order object
	 *
	 * @return double
	 */
	public function computeTotalCollections();

	/**
	 * Get sum of all fees in order 
	 *
	 * @return double
	 */
	public function computeTotalSales();

}