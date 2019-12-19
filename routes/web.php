<?php

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

Route::get('/', [
    'uses' => 'EmployeeController@show',
    'as' => 'employee.show'
]);

Route::post('/create', [
    'uses' => 'EmployeeController@create',
    'as' => 'employee.create'
]);

Route::post('employee-work-hours/create', [
    'uses' => 'EmployeeWorkHoursController@create',
    'as' => 'employeeWorkHours.create'
]);
/*Renders employee view*/
Route::get('/view/{id}', [
    'uses' => 'EmployeeController@view',
]);
/*Renders edit employee view*/
Route::get('/edit/{id}', [
    'uses' => 'EmployeeController@editView',
]);
/*Saving edit form*/
Route::post('/edit', [
    'uses' => 'EmployeeController@editPost',
    'as' => 'employee.edit'
]);
/*Delete of employee*/
Route::delete('/employee/delete/{id}', 'EmployeeController@destroy');
/*Delete of employee wok hours*/
Route::delete('/employee-work-hours/delete/{id}', 'EmployeeWorkHoursController@destroy');

/*Renders edit employee workhours view*/
Route::get('/employee-work-hours/edit/{id}', [
    'uses' => 'EmployeeWorkHoursController@editView',
]);

/*Saving edit form*/
Route::post('/employee-work-hours/edit', [
    'uses' => 'EmployeeWorkHoursController@editPost',
    'as' => 'employee-work-hours.edit'
]);


