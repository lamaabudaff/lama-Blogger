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

Route::get('/', function () {
    return view('admin.blogs.index');
});


Route::get('admin/login',[\App\Http\Controllers\AuthController::class,'show_login'])->name('login')->middleware('guest');
Route::post('admin/login',[\App\Http\Controllers\AuthController::class,'do_login'])->name('do_login');


Route::get('test',function (){
    $category = \App\Models\Category::with('blogs')->find(10);
    foreach ($category->blogs as $blog){
        echo $blog->title."<br>";
    }
    return "";
});
