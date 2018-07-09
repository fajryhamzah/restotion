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


//register handling
Route::post('/register','DashboardController@register');
//login handling
Route::post('/login','DashboardController@login');
