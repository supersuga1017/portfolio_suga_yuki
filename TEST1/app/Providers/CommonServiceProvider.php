<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Customer;


// これをuseしておかないと完全修飾子で書く必要がある
use Illuminate\Support\Facades\View;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        

        // $customer_id = 6;
        // //対応するIDの得意先名を返す
        // $customer = Customer::where('id',$customer_id)->value('name');
        // // 全てのViewから $customer の値を取得できる
        // View::share('customer', $customer);
        View::share('customer', "青山銀行");


    }
}
