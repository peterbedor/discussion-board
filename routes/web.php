<?php

Route::get('/', function() {
    return view('index');
})->middleware('auth');

Auth::routes();
