<?php

namespace App\Services;

use App\Contracts\OrderAPIClientRequestInterface;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class OrderAPIClientRequest implements OrderAPIClientRequestInterface
{

	/**
	 * @var string
	 */
	private $baseUri;

	/**
	 * @var array
	 */
	private $headers;

	/**
	 * @var array
	 */
	private $orderList;

	/**
	 * @var GuzzleHttp\Client Object
	 */
	private $client;

	/**
	 * @var GuzzleHttp\Promise Response
	 */
	protected $result;

	/**
	 * Set order base uri of third party API request
	 *
	 * @param string $baseUri
	 * @return void
	 */
	public function setBaseUri($baseUri)
	{
		$this->baseUri = $baseUri;
	}

	/**
	 * Set request headers of third part API request
	 *
	 * @param array $headers
	 * @return  void 
	 */
	public function setHeaders($headers)
	{
		$this->headers = [
			'headers'	=> $headers
		];
	}

	/**
	 * Set endpoint for each order to be called
	 *
	 * @param array $orderList 
	 * @return void 
	 */
	public function setOrderRequestList($orderList)
	{
		$this->orderList = $orderList;
	}

	/**
	 * Call order third party API request
	 *
	 * @return GuzzleHttp\Promise Response
	 */
	public function callOrderRequest()
	{
		$this->client = new Client([
			'base_uri'		=> $this->baseUri,
			'headers'		=> $this->headers
		]);
		$asyncRequest = [];
		foreach ($this->orderList as $orderList) {
			$asyncRequest[] = $this->client->getAsync($orderList);
		}
        $this->result = Promise\unwrap($asyncRequest);
        $this->result = Promise\settle($asyncRequest)->wait();
        return $this->result;
	}

}