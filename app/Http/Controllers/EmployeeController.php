<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Employee_workhours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * a method that creates new employee
     */
    public function create(Request $request) {
        $employee = new Employee();
        $validationResult = $employee->validate($request->all());

        if($validationResult !== true) {
            return redirect('/')->with(['errors' => $validationResult]);
        }

        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $address = $request['address'];
        $hiring_date = $request['hiring_date'];
        $birth_date = $request['birth_date'];
        $salary = $request['salary'];

        $employee->first_name = $first_name;
        $employee->last_name = $last_name;
        $employee->address = $address;
        $employee->hiring_date = $hiring_date;
        $employee->birth_date = $birth_date;
        $employee->salary = $salary;

        $employee->save();

        return redirect()->back();
    }

    /**
     * a method that shows employee view
     */
    public function view($id) {
        $employee = Employee::find($id);
        $employeeWorkHours = Employee_workhours::where('employee_id', $id)->get();
        $errors = '';

        if (!empty(Session::get('errors'))) {
            $errors = Session::get('errors');
        }

        return view('view_employee', ['employee' => $employee, 'employeeWorkHours' => $employeeWorkHours, 'errors' => $errors]);
    }

    /**
     * a method that shows employee edit view
     */
    public function editView($id) {
        $employee = Employee::find($id);
        $errors = '';

        if (!empty(Session::get('errors'))) {
            $errors = Session::get('errors');
        }

        return view('edit_employee', ['employee' => $employee, 'errors' => $errors]);
    }

    /**
     * a method that edits existing employee
     */
    public function editPost(Request $request) {
        $employee = new Employee();
        $validationResult = $employee->validate($request->all());

        if($validationResult !== true) {
            return redirect('/edit/'.$request['id'])->with(['errors' => $validationResult]);
        }

        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $address = $request['address'];
        $hiring_date = $request['hiring_date'];
        $birth_date = $request['birth_date'];
        $salary = $request['salary'];

        $employee = Employee::find((int)$request['id']);

        $employee->first_name = $first_name;
        $employee->last_name = $last_name;
        $employee->address = $address;
        $employee->hiring_date = $hiring_date;
        $employee->birth_date = $birth_date;
        $employee->salary = $salary;

        $employee->save();

        return redirect('/view/'.$request['id'])->with('success');
    }

    /**
     * a method that shows all employees
     */
    public function show() {
        $employees = Employee::all();
        $errors = '';

        if (!empty(Session::get('errors'))) {
            $errors = Session::get('errors');
        }

        return view('index', ['employees' => $employees, 'errors' => $errors]);
    }

    /**
     * a method that delete an employee basing on it's $id
     */
    public function destroy($id)
    {
        // Firstly we have to destroy all of employee work hours because of constraint
        $employeeWorkHours = Employee_workhours::where('employee_id', $id)->get();

        if(!empty($employeeWorkHours)) {
            foreach($employeeWorkHours as $workHour) {
                Employee_workhours::destroy($workHour->id);
            }
        }

        Employee::destroy($id);                 // Now we can destroy our employee

        return response()->json([
            'success' => 'Record has been deleted successfully!'
        ]);
    }
}
