<?php

use Illuminate\Http\Request;
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

Route::get('/', 'BuyController@index');

Auth::routes();

Route::get('manage','ManageController@index')->name('manage');

Route::post('/uploadproduct', 'ProductController@uploadDataProduct');

Route::get('cashhead', 'CashHeadController@index')->name('cashhead');

Route::get('typecash', 'CashHeadController@typecash')->name('typecash');

Route::get('/createtypecash', 'CashHeadController@create');

Route::post('/updateCashHead/{id?}', 'CashHeadController@update');

Route::get('/delcash_head/{id?}','CashHeadController@delete');

Route::post('/editproduct/{id?}/{product_image?}', 'ProductController@editProduct');

Route::get('/del_product/{id?}','ProductController@delete');

Route::get('/addTotal/{num?}/{total_left?}', 'BuyController@Addtotal');

Route::get('/buyProduct/{price?}/{id_product?}/{total?}/{product_amount?}', 'BuyController@Buyproduct');
