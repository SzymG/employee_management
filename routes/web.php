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

Route::get('/', function () {
    return redirect('/login');
});

//Route::get('/manage', [
//    'uses' => 'EmployeeController@show',
//    'as' => 'employee.show'
//])->middleware('auth');

Route::post('/create', [
    'uses' => 'EmployeeController@create',
    'as' => 'employee.create'
])->middleware('auth');

Route::post('employee-work-hours/create', [
    'uses' => 'EmployeeWorkHoursController@create',
    'as' => 'employeeWorkHours.create'
])->middleware('auth');

/*Renders employee view*/
Route::get('/view/{id}', [
    'uses' => 'EmployeeController@view'
])->middleware('auth');

/*Renders edit employee view*/
Route::get('/edit/{id}', [
    'uses' => 'EmployeeController@editView',
])->middleware('auth');

/*Saving edit form*/
Route::post('/edit', [
    'uses' => 'EmployeeController@editPost',
    'as' => 'employee.edit'
])->middleware('auth');

/*Delete of employee*/
Route::delete('/employee/delete/{id}', 'EmployeeController@destroy')->middleware('auth');

/*Delete of employee wok hours*/
Route::delete('/employee-work-hours/delete/{id}', 'EmployeeWorkHoursController@destroy')->middleware('auth');

/*Renders edit employee workhours view*/
Route::get('/employee-work-hours/edit/{id}', [
    'uses' => 'EmployeeWorkHoursController@editView',
])->middleware('auth');

/*Saving edit form*/
Route::post('/employee-work-hours/edit', [
    'uses' => 'EmployeeWorkHoursController@editPost',
    'as' => 'employee-work-hours.edit'
])->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
