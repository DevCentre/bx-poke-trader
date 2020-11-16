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

Route::post('/saveTrade', 'pokedexController@save');

Route::get('/tradeHistory', 'pokedexController@getTradeHistory');

Route::get('/getDataPokedex/{pageOffset}/{qSearch}', 'pokedexController@getIncrementalData');
