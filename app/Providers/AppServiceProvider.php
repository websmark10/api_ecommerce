<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */


    public function boot()
    {
        /*
        $user = Auth::user();
        $folderCompanie = "HOLA";//str_pad( Auth::user()->id,4, "0", STR_PAD_LEFT)  ;
        View::share(['user'=>$user,'folderCompanie'=>$folderCompanie]);*/

        view()->share('*',function($view) {
            $view->with('user', Auth::user());
            $view->with('folderCompanie',"Hola");
        });


    }
}
