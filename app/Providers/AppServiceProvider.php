<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            // $view->with('dollar_rate', Session::get('dollar_rate'));
            // $view->with('is_nigeria', Session::get('is_nigeria'));

            if(Auth::user()){
                $user_country = Auth::user()->country_id;
                $user_currency = 'dollar';
                if($user_country == 566){
                    $user_currency = 'naira';
                    $view->with('user_currency', $user_currency);
                }
                $view->with('user_currency', $user_currency);
            }
            // dd($user_currency);
        });
        // $val = Session::get('dollar_rate');
        // $val = $request->session()->get('key', 'default');;

        // $response = Http::get('https://free.currconv.com/api/v7/convert?q=USD_NGN&compact=ultra&apiKey=8fa6c6f0698970300589');

        $response = Http::get('https://openexchangerates.org/api/latest.json?app_id=8c8c207bcbab4c14970a06d7fd4f92c2');
        $resp = json_decode($response);
        $dollar_rate = $resp->rates->NGN;


        // $is_nigeria = false;


        $file_location = "storage/pictures/";
        View::share([
            'file_location' => $file_location,
            'dollar_rate' => $dollar_rate,
        ]);
    }
}