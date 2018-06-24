<?php

namespace App\Services;

use App\Contracts\PrepareOrderBreakDownFeesInterface;

class PrepareOrderBreakDownFees implements PrepareOrderBreakDownFeesInterface
{

	/**
	 * @var array
	 */
	protected $breakdown;

	/**
	 * @var array
	 */
	protected $fees;

	/**
	 * Combine values for breakdown
	 *
	 * @param  object $order 
	 * @return array
	 */
	public function combineBreakdown($order)
	{
		$this->breakdown = [
			'subtotal'		=> $order->subtotal,
			'shipping'		=> $order->shipping,
			'tax'			=> $order->tax,
			'fee'			=> $order->fee,
			'insurance'		=> $order->insurance,
			'discount'		=> $order->discount,
			'total'			=> $order->total
		];
		return $this->breakdown;
	}

	/**
	 * Combine values for fees
	 *
	 * @param  object $order 
	 * @return array
	 */
	public function combineFees($order)
	{
		$this->fees = [
			'shipping_fee'		=> $order->shipping_fee,
			'insurance_fee'		=> $order->insurance_fee,
			'transaction_fee'	=> $order->transaction_fee
		];	
		return collect($this->fees);
	}
	
}