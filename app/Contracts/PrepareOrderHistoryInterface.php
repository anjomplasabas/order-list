<?php

namespace App\Contracts;

interface PrepareOrderHistoryInterface
{

	/**
	 * Set order of tat by date and time ascending
	 *
	 * @param  object $order 
	 * @return array
	 */
	public function orderByDateTimeAscending($order);

}