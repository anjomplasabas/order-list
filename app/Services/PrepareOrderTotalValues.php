<?php

namespace App\Services;

use App\Contracts\PrepareOrderTotalValuesInterface;

class PrepareOrderTotalValues implements PrepareOrderTotalValuesInterface
{

	/**
	 * @var object
	 */
	private $order;

	/**
	 * Set order json object
	 *
	 * @param object $order
	 */
	public function setOrder($order)
	{
		$this->order = $order;
	}

	/**
	 * Get total value of order object
	 *
	 * @return double
	 */
	public function computeTotalCollections()
	{
		return $this->order->total;
	}

	/**
	 * Get sum of all fees in order 
	 *
	 * @return double
	 */
	public function computeTotalSales()
	{
		return $this->order->shipping_fee + $this->order->insurance_fee + $this->order->transaction_fee;
	}

}