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




Route::group(['prefix'=> LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
],function (){
    Route::group(['prefix'=>'admin','as'=>'admin.'],function (){
        Route::group(['prefix'=>'blogs','as'=>'blogs.','middleware'=>'web'],function (){
            Route::get('',[\App\Http\Controllers\Admin\BlogsController::class,'index'])->name('index'); // blogs.index
            Route::get('create',[\App\Http\Controllers\Admin\BlogsController::class,'create'])->name('create');
            Route::post('store',[\App\Http\Controllers\Admin\BlogsController::class,'store'])->name('store');
            Route::post('delete/{id}',[\App\Http\Controllers\Admin\BlogsController::class,'delete'])->name('delete');
            Route::get('edit/{id}',[\App\Http\Controllers\Admin\BlogsController::class,'edit'])->name('edit');
            Route::post('update/{id}',[\App\Http\Controllers\Admin\BlogsController::class,'edit'])->name('update');
            Route::get('{id}',[\App\Http\Controllers\Admin\BlogsController::class,'show'])->name('show'); // blogs.index

        });
    });


});



