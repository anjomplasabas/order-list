<?php

namespace App\Services;

use App\Contracts\ArrangeOrderResponseInterface;
use App\Contracts\PrepareOrderBreakDownFeesInterface;
use App\Contracts\PrepareOrderTotalValuesInterface;
use App\Contracts\PrepareOrderHistoryInterface;

class ArrangeOrderResponse implements ArrangeOrderResponseInterface
{

	/**
	 * @var array
	 */
	private $responseFormat;

	/**
	 * @var Collection
	 */
	private $responseCollection;

	/**
	 * @var PrepareOrderBreakDownFeesInterface
	 */
	private $prepareOrderBreakdownFees;

	/**
	 * @var PrepareOrderTotalValuesInterface
	 */
	private $prepareOrderTotalValues;

	/**
	 * @var PrepareOrderHistoryInterface
	 */
	private $prepareOrderHistory;

	/**
	 * @var double
	 */
	private $totalCollections;

	/**
	 * @var double
	 */
	private $totalSales;

	/**
	 * Initialze service class
	 *
	 * @param PrepareOrderBreakDownFeesInterface $prepareOrderBreakdownFees 
	 * @param PrepareOrderTotalValuesInterface $prepareOrderTotalValues 
	 * @param PrepareOrderHistoryInterface $prepareOrderHistory 
	 */
	public function __construct(PrepareOrderBreakDownFeesInterface $prepareOrderBreakdownFees, PrepareOrderTotalValuesInterface $prepareOrderTotalValues, PrepareOrderHistoryInterface $prepareOrderHistory)
	{
		$this->prepareOrderBreakdownFees = $prepareOrderBreakdownFees;
		$this->prepareOrderTotalValues = $prepareOrderTotalValues;
		$this->prepareOrderHistory = $prepareOrderHistory;
	}

	/**
	 * Arrange orders parameter into console format
	 *
	 * @param  object $orders 
	 * @return array      
	 */
	public function prepareFormat($orders)
	{
		if (count($orders) > 0) {
			foreach ($orders as $order) {
				// Decode json string to object
				$jsonFormatOrder = json_decode($order['value']->getBody());
				// Compute total values of order
				$this->prepareOrderTotalValues->setOrder($jsonFormatOrder);
				$this->totalCollections += $this->prepareOrderTotalValues->computeTotalCollections();
				$this->totalSales += $this->prepareOrderTotalValues->computeTotalSales();
				// Prepare console format
				$this->responseFormat[] = [
					'id'			=> $jsonFormatOrder->id,
					'headers'		=> $jsonFormatOrder->tracking_number.' ('.$jsonFormatOrder->status.') ',
					'history'		=> $this->prepareOrderHistory->orderByDateTimeAscending($jsonFormatOrder),
					'breakdown'		=> $this->prepareOrderBreakdownFees->combineBreakdown($jsonFormatOrder),
					'fees'			=> $this->prepareOrderBreakdownFees->combineFees($jsonFormatOrder)
				];
			}
			// Set response format into collection object
			$this->responseCollection = collect($this->responseFormat);
			// Sort by order id ascending
			$sorted = $this->responseCollection->sortBy('id');
			return [
				'list'				=> $sorted->values()->all(),
				'total_collections'	=> $this->totalCollections,
				'total_sales'		=> $this->totalSales
			];
		}
	}

}