<?php

namespace App\Contracts;

interface PrepareOrderBreakDownFeesInterface
{

	/**
	 * Combine values for breakdown
	 *
	 * @param  object $order 
	 * @return array
	 */
	public function combineBreakdown($order);

	/**
	 * Combine values for fees
	 *
	 * @param  object $order 
	 * @return array
	 */
	public function combineFees($order);

}