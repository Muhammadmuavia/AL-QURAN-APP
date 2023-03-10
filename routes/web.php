<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\products;

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

// Route::get('/', function () {
//     return view('welcome');
// });
// route::get("list",[products::class,'product updated']);
// route::get("Add",[products::class,'Addproduct']);
// route::get("Updated",[products::class,'productupdate']);

route::controller(products::class)->group(function(){
    route::get("list",'productlist');
     route::get("Add",'Addproduct');
    route::get("Update",'Updateproduct');

});

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);
    Route::resource('languages', 'Backend\LanguagesController', ['names' => 'admin.languages']);
    Route::resource('surats', 'Backend\SuratsController', ['names' => 'admin.surats']);
    Route::resource('ayats', 'Backend\AyatsController', ['names' => 'admin.ayats']);
    Route::resource('qirats', 'Backend\QiratsController', ['names' => 'admin.qirats']);


    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
});
