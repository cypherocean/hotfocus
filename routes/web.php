<?php

use Illuminate\Support\Facades\Route;

Route::get('command/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "config, cache, and view cleared successfully";
});

Route::get('command/config', function () {
    Artisan::call('config:cache');
    return "config cache successfully";
});

Route::get('command/key', function () {
    Artisan::call('key:generate');
    return "Key generate successfully";
});

Route::get('command/migrate', function () {
    Artisan::call('migrate');
    return "Database migration generated";
});

Route::get('seed', function () {
    Artisan::call('db:seed');
    return "Database seeding generated";
});

Route::group(['middleware' => ['prevent-back-history']], function () {
    // Route::group(['middleware' => ['guest']], function () {
    //     Route::get('/', 'AuthController@login')->name('login');
    //     Route::post('signin', 'AuthController@signin')->name('signin');

    //     Route::get('forget-password', 'AuthController@forget_password')->name('forget.password');
    //     Route::post('password-forget', 'AuthController@password_forget')->name('password.forget');
    //     Route::get('reset-password/{string}', 'AuthController@reset_password')->name('reset.password');
    //     Route::post('recover-password', 'AuthController@recover_password')->name('recover.password');
    // });

    // Route::group(['middleware' => ['auth']], function () {
    //     Route::get('logout', 'AuthController@logout')->name('logout');
        Route::get('/', function(){
            return view('dashboard');
        });
        Route::get('/dashboard', function(){
            return view('dashboard');
        })->name('dashboard');
    // });

    // Route::get("{path}", function () {
    //     return redirect()->route('login');
    // })->where('path', '.+');
});
