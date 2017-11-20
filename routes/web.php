<?php

use App\Backtrace;

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

Route::get('/normal', function () {
    return view("normal", [
        "trace" => Backtrace::toHere(),
    ]);
});

Route::get('/broken', function () {
    abort(404);
});

Route::fallback(function () {
    return view("broken", [
        "trace" => Backtrace::toHere(),
    ]);
})->name("fallback");
