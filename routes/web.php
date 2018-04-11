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
use App\Events\setNotBusy;
use App\Marketinglist;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Import
Route::get('/import', 'ExcelController@importIndex');
Route::post('/import', 'ExcelController@importExcel');

//Hubspot
Route::get('/hubspot/login', 'HubspotController@login');
//Route::get('/response', 'HubspotController@response');

//Bellijst
Route::get('/bellijstkiezen', 'BellijstController@index')->middleware('auth');
Route::get('/bellijstkiezen/{marketinglist}', 'BellijstController@setNotBusy')->middleware('auth');
Route::get('/bellen/{marketinglist}', 'BellijstController@bellen')->middleware('auth');

//ResultsController
Route::get('/bellen/sale/{customer}', 'ResultController@sale');




//Exact
Route::get('/exact/login', 'ExactController@login');
Route::get('/response', 'ExactController@response');
Route::post('/response', 'ExactController@verify');
Route::post('/exact/hubspot', 'ExactController@import');
Route::get('/refresh', 'ExactController@refresh');
Route::get('/download', 'ExactController@download');



//Event
Route::get('/event', function (){

       return view('exact/import');

});





