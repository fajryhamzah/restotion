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

//register
Route::get('/register',function (){
    return view("register");
});

//Login
Route::get('/login',function(){
    return view("login");
});

//Dashboard
Route::get('/dashboard',function(){
    return view("dashboard");
});

//add restaurant form
Route::get("/add_restaurant",function(){
    return view("restaurant/add");
});

//konfirmasi Email
Route::get("/konfirmasi/{hash}","DashboardController@konfirmasi");


//register handling
Route::post('/register','DashboardController@register');
//login handling
Route::post('/login','DashboardController@login');
//add restaurant data
Route::post('/add_restaurant','RestoranController@addRestoran');
