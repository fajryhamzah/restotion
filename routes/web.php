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
  Route::get("/konfirmasi/{hash}","DashboardController@konfirmasi");
  //register
  Route::get('/register',function (){
      return view("register");
  });
  //Login
  Route::get('/login',function(){
      return view("login");
  });

  //register handling
  Route::post('/register','DashboardController@register');
  //login handling
  Route::post('/login','DashboardController@login');

});

//WHEN USER HAS LOGIN
Route::group(['middleware' => 'pass'], function () {
  //Dashboard
  Route::get('/dashboard',"DashboardController@dashboardInterface");

  //add restaurant form
  Route::get("/add_restaurant",function(){
      return view("restaurant/add");
  });

  //add restaurant data
  Route::post('/add_restaurant','RestoranController@addRestoran');
  //logout
  Route::get("/logout","DashboardController@logout");
});
