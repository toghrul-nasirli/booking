<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '^(?!api\/)[\/\w\.\,-]*');
