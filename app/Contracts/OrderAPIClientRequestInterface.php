<?php

namespace App\Contracts;

interface OrderAPIClientRequestInterface
{

	/**
	 * Set order base uri of third party API request
	 *
	 * @param string $baseUri
	 * @return void
	 */
	public function setBaseUri($baseUri);

	/**
	 * Set request headers of third part API request
	 *
	 * @param array $headers
	 * @return  void 
	 */
	public function setHeaders($headers);

	/**
	 * Set endpoint for each order to be called
	 *
	 * @param array $orderList 
	 * @return void 
	 */
	public function setOrderRequestList($orderList);

	/**
	 * Call order third party API request
	 *
	 * @return array
	 */
	public function callOrderRequest();

}