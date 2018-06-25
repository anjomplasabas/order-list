<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

use App\Contracts\PrepareOrderTotalValuesInterface;
use App\Contracts\OrderAPIClientRequestInterface;
use App\Contracts\ArrangeOrderResponseInterface;

class GetOrdersCommand extends Command
{

	/**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'orders:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all orders from third party API';

    /**
     * @var object
     */
    private $orders;

    /**
     * @var array
     */
    private $orderEndpoints;

    /**
     * @var Collection
     */
    private $formattedOrders;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(OrderAPIClientRequestInterface $orderApi, ArrangeOrderResponseInterface $arrangeOrderResponse, PrepareOrderTotalValuesInterface $prepareOrderTotalValues)
    {
    	$orderApi->setBaseUri('https://api.staging.lbcx.ph/v1/orders/');
        $orderApi->setHeaders([
            'X-Time-Zone'   => 'Asia/Manila'
        ]);
        $this->orderEndpoints = [
            '0077-6495-AYUX',
            '0077-6491-ASLK',
            '0077-6490-VNCM',
            '0077-6478-DMAR',
            '0077-1456-TESV',
            '0077-0836-PEFL',
            '0077-0526-EBDW',
            '0077-0522-QAYC',
            '0077-0516-VBTW',
            '0077-0424-NSHE'
        ];
        $orderApi->setOrderRequestList($this->orderEndpoints);
        $this->orders = $orderApi->callOrderRequest();
        $this->formattedOrders = $arrangeOrderResponse->prepareFormat($this->orders);
        foreach ($this->formattedOrders['list'] as $formattedOrder) {
        	echo $formattedOrder['headers'].":\r\n";
        	echo "\thistory:\r\n";
        	foreach ($formattedOrder['history'] as $history) {
        		echo "\t\t".$history['timestamp'].": ".$history['status']."\r\n";
        	}
        	echo "\tbreakdown:\r\n";
        	foreach ($formattedOrder['breakdown'] as $breakdownIndex => $breakdownValue) {
        		echo "\t\t".$breakdownIndex.': '.$breakdownValue."\r\n";
        	}
        	echo "\tfees:\r\n";
        	foreach ($formattedOrder['fees'] as $feesIndex => $feesValue) {
        		echo "\t\t".$feesIndex.': '.$feesValue."\r\n";
        	}
        }
        echo "total collections: ".$this->formattedOrders['total_collections']."\r\n";
        echo "total sales: ".$this->formattedOrders['total_sales'];
    }

}