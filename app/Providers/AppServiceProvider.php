<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $display = Setting::where('user_id','=',Auth::user()->id)->first();
                $view->with('display', $display);
            }
        });
    }
}
