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

Route::get('/', "RestoranController@frontInterface");
Route::post('/', "RestoranController@search");
Route::get('/restoran/{id}', "RestoranController@restoranDetailInterface");
Route::get('/restoran/menu/{id}', "RestoranController@lihatMenuInterface");
Route::get('/restoran/galeri/{id}', "RestoranController@lihatGaleriInterface");
Route::get('/restoran/meja/{id}', "RestoranController@lihatMejaInterface");
Route::get("/resto", "RestoranController@listRestoranInterface");

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

  //Detail Restaurant
  Route::get("dashboard/{id}","RestoranController@detailInterface");
  Route::post("dashboard/{id}","RestoranController@detail");

  //gallery
  Route::get("dashboard/gallery/{id}","RestoranController@galleryInterface");
  Route::get("dashboard/gallery/{id}/delete/{im}","RestoranController@galleryDelete");
  Route::post("dashboard/gallery/{id}","RestoranController@galleryAdd");

  //Menu
  Route::get("dashboard/menu/{id}","RestoranController@menuInterface");
  Route::get("dashboard/menu/{id}/delete/{mn}","RestoranController@deleteMenu");
  Route::get("dashboard/menu/add/{id}","RestoranController@addMenuInterface");
  Route::get("dashboard/menu/{id}/edit/{mn}","RestoranController@editMenuInterface");
  Route::post("dashboard/menu/{id}/edit/{mn}","RestoranController@editMenu");
  Route::post("dashboard/menu/add/{id}","RestoranController@addMenu");

  //Meja
  Route::get("dashboard/meja/{id}","RestoranController@mejaInterface");
  Route::get("dashboard/meja/add/{id}","RestoranController@addMejaInterface");
  Route::get("dashboard/meja/{id}/edit/{mj}","RestoranController@editMejaInterface");
  Route::post("dashboard/meja/{id}/edit/{mj}","RestoranController@editMeja");
  Route::post("dashboard/meja/add/{id}","RestoranController@addMeja");
  Route::get("dashboard/meja/{id}/delete/{mn}","RestoranController@deleteMeja");
  Route::get("dashboard/meja/{id}/status/{mn}","RestoranController@statusMeja");

  //delete Restaurant
  Route::get("dashboard/delete/{id}","RestoranController@deleteRestoran");

  //add restaurant form
  Route::get("add_restaurant","RestoranController@addRestoranInterface");

  //setting
  Route::get('setting','DashboardController@settingInterface');
  Route::post('setting','DashboardController@settingSave');

  //add restaurant data
  Route::post('add_restaurant','RestoranController@addRestoran');

  //logout
  Route::get("logout","DashboardController@logout");
});
