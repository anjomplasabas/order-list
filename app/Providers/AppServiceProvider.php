<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    	$this->app->bind(
            'App\Contracts\OrderAPIClientRequestInterface', 
            'App\Services\OrderAPIClientRequest'
        );
    	$this->app->bind(
            'App\Contracts\ArrangeOrderResponseInterface', 
            'App\Services\ArrangeOrderResponse'
        );
        $this->app->bind(
            'App\Contracts\PrepareOrderBreakDownFeesInterface', 
            'App\Services\PrepareOrderBreakDownFees'
        );
        $this->app->bind(
            'App\Contracts\PrepareOrderTotalValuesInterface', 
            'App\Services\PrepareOrderTotalValues'
        );
        $this->app->bind(
            'App\Contracts\PrepareOrderHistoryInterface', 
            'App\Services\PrepareOrderHistory'
        );
    }
}
