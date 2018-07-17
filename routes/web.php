<?php

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

Route::get('/', function () {
    return view('welcome');
});

//WHEN USER HAS NOT LOGIN
Route::group(['middleware' => 'notpass'], function () {
  //konfirmasi Email
  Route::get("konfirmasi/{hash}","DashboardController@konfirmasi");
  //register
  Route::get('register',"DashboardController@registerInterface");
  //Login
  Route::get('login',"DashboardController@loginInterface");
  //register handling
  Route::post('register','DashboardController@register');
  //login handling
  Route::post('login','DashboardController@login');
});


//WHEN USER HAS LOGIN
Route::group(['middleware' => 'pass'], function () {
  //Dashboard
  Route::get('dashboard',"DashboardController@dashboardInterface");

  //Dashboard Inside Restaurant
  Route::get("dashboard/{id}","RestoranController@dashboardInsideRestoranInterface");

  //add restaurant form
  Route::get("add_restaurant","RestoranController@addRestoranInterface");

  //edit account
  Route::get('setting','DashboardController@settingInterface');
  Route::post('setting','DashboardController@settingSave');

  //add restaurant data
  Route::post('add_restaurant','RestoranController@addRestoran');

  //logout
  Route::get("logout","DashboardController@logout");
});
