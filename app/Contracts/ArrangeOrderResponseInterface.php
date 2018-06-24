<?php

namespace App\Contracts;

interface ArrangeOrderResponseInterface
{

	/**
	 * Arrange orders parameter into console format
	 *
	 * @param  object $orders 
	 * @return array      
	 */
	public function prepareFormat($orders);

}