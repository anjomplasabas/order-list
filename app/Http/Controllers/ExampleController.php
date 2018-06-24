<?php

namespace App\Http\Controllers;

use App\Contracts\OrderAPIClientRequestInterface;
use App\Contracts\ArrangeOrderResponseInterface;

class ExampleController extends Controller
{

    /**
     * @var OrderAPIClientRequestInterface
     */
    protected $orderApi;

    /**
     * @var ArrangeOrderResponseInterface
     */
    protected $arrangeOrderResponse;

    /**
     * Initialze controller instance.
     *
     * @return void
     */
    public function __construct(OrderAPIClientRequestInterface $orderApi, ArrangeOrderResponseInterface $arrangeOrderResponse)
    {
        $this->orderApi = $orderApi;
        $this->arrangeOrderResponse = $arrangeOrderResponse;
    }

    public function index()
    {
        // $this->orderApi->setBaseUri('http://lcoalhost/QUAD-X-PROXY/');
        $this->orderApi->setBaseUri('https://api.staging.lbcx.ph/v1/orders/');
        $this->orderApi->setHeaders([
            'X-Time-Zone'   => 'Asia/Manila'
        ]);
        $promises = [
            // '0077-6495-AYUX.json',
            // '0077-6491-ASLK.json',
            // '0077-6490-VNCM.json',
            // '0077-6478-DMAR.json',
            // '0077-1456-TESV.json',
            // '0077-0836-PEFL.json',
            // '0077-0526-EBDW.json',
            // '0077-0522-QAYC.json',
            // '0077-0516-VBTW.json',
            // '0077-0424-NSHE.json'
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
        $this->orderApi->setOrderRequestList($promises);
        $orders = $this->orderApi->callOrderRequest();

        $responseBody = $this->arrangeOrderResponse->prepareFormat($orders);
        return $responseBody;

    }

}
