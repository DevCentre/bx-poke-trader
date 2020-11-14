<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'pokedexController@getPokedexData');

Route::get('/updatePokedex', 'pokedexController@update');


// Route::get('/home', function () {
//     $all = DB::table('trade_history')
//     ->get();
//     dd($all);
//     // return view('welcome');
// });
