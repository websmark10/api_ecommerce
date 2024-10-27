<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ecommerce\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {

    return view('welcome');
});
*/

Route::get('/', function () {

    return view('welcome');
});



 Route::post('test/api/ecommerce/home', [HomeController::class, 'home'], function(Request $data){
   // Debugbar::debug($query);
  //return view('welcome',['data'=>$data]);
  //return view('welcome');
  // return "hola";
 })->name('home');


/*
Route::post('/api/ecommerce/home',  ['companie_id' => '1', 'uses' => HomeController::class, 'home']
    // Debugbar::debug($query);
    //  return view('welcome');
);*/


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
