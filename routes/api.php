<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Role;
use App\User;
use App\Category;
use App\Expense;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/reports', function (Request $request) {
    return Expense::groupBy('category_id')
        ->select('categories.name as category_name')
        ->selectRaw('sum(amount) as sum')
        ->join('categories','categories.id','expenses.category_id')
        ->get();
});

Route::get('/roles', function (Request $request) {
    return Role::all();
});

Route::get('/users', function (Request $request) {
    return User::select(
        'users.id',
        'users.name',
        'users.email',
        'roles.id as role_id',
        'roles.name as role_name',
        'users.created_at'
    )
    ->leftJoin('roles','roles.id','users.role_id')
    ->get();
});

Route::get('/categories', function (Request $request) {
    return Category::all();
});

Route::get('/expenses', function (Request $request) {
    return Expense::select(
        'expenses.id',
        'expenses.amount',
        'expenses.entry_date',
        'categories.id as category_id',
        'categories.name as category_name',
        'expenses.created_at'
    )->join('categories','categories.id','expenses.category_id')
    ->get();
});


