<?php

namespace App\Services;

use App\Contracts\PrepareOrderHistoryInterface;

use \Carbon\Carbon;

class PrepareOrderHistory implements PrepareOrderHistoryInterface
{

	/**
	 * @var array
	 */
	private $orderHistory;

	/**
	 * @var Collection
	 */
	private $historyCollection;

	/**
	 * Set order of tat by date and time ascending
	 *
	 * @param  object $order 
	 * @return array
	 */
	public function orderByDateTimeAscending($order)
	{
		$this->orderHistory = [];
		foreach ($order->tat as $status => $details) {
			$orderTat = Carbon::createFromTimestamp($details)->setTimezone('Asia/Manila');
			$this->orderHistory[] =[
				'timestamp'		=> $orderTat->format('Y-m-d H:i:s.u'),
				'status'		=> $status
			];
		}
		$this->historyCollection = collect($this->orderHistory);
		$sorted = $this->historyCollection->sortBy('timestamp');
		return $sorted->values()->all();
	}

}