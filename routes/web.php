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

Auth::routes();

Route::get('/{any}', 'PuppleBugController@dashboard')->where('any', '.*');


Route::post('/change/password','PuppleBugController@change_password');


/*=====================================================*/
/*				          Roles                        */ 
/*=====================================================*/
Route::post('/roles/insert','RoleController@insert');
Route::post('/roles/update','RoleController@update');
Route::post('/roles/delete','RoleController@delete');

/*=====================================================*/
/*				          Users                        */ 
/*=====================================================*/
Route::post('/users/insert','UserController@insert');
Route::post('/users/update','UserController@update');
Route::post('/users/delete','UserController@delete');

/*=====================================================*/
/*				       Categories                      */ 
/*=====================================================*/
Route::post('/categories/insert','CategoryController@insert');
Route::post('/categories/update','CategoryController@update');
Route::post('/categories/delete','CategoryController@delete');

/*=====================================================*/
/*				        Expenses                       */ 
/*=====================================================*/
Route::post('/expenses/insert','ExpenseController@insert');
Route::post('/expenses/update','ExpenseController@update');
Route::post('/expenses/delete','ExpenseController@delete');
