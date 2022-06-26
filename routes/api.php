<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
/// Company Model Start  /////////
Route::post('company_list','Api\CompanyController@index')->name('company_list');
Route::post('company_store','Api\CompanyController@store')->name('company_store');
Route::put('company_update','Api\CompanyController@update')->name('company_update');
Route::delete('company_delete/{id}','Api\CompanyController@destroy')->name('company_delete');
Route::get('get_company_details/{id}','Api\CompanyController@show')->name('get_company_details');
/// Company Model End  /////////


/// Department Model Start  /////////
Route::post('department_list','Api\DepartmentController@index')->name('department_list');
Route::post('department_store','Api\DepartmentController@store')->name('department_store');
Route::put('department_update','Api\DepartmentController@update')->name('department_update');
Route::delete('department_delete/{id}','Api\DepartmentController@destroy')->name('department_delete');
Route::get('get_department_details/{id}','Api\DepartmentController@show')->name('get_department_details');
/// Department Model End  /////////



/// User Model Start  /////////
Route::post('user_list','Api\userController@index')->name('user_list');
Route::post('user_store','Api\userController@store')->name('user_store');
Route::put('user_update','Api\userController@update')->name('user_update');
Route::delete('user_delete/{id}','Api\userController@destroy')->name('user_delete');
Route::get('get_user_details/{id}','Api\userController@show')->name('get_user_details');
/// User Model End  /////////


/// User Details Model Start  /////////
Route::post('user_details_list','Api\UserDetailController@index')->name('user_details_list');
Route::post('user_details_store','Api\UserDetailController@store')->name('user_details_store');
Route::put('user_details_update','Api\UserDetailController@update')->name('user_details_update');
Route::delete('user_details_delete/{id}','Api\UserDetailController@destroy')->name('user_details_delete');
Route::get('get_user_data/{id}','Api\UserDetailController@show')->name('get_user_data');
/// User  Details Model End  /////////

