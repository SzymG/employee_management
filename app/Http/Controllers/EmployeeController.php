<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Employee_workhours;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    /**
     * a method that creates new employee
     */
    public function create(Request $request) {
        $employee = new Employee();
        $validationResult = $employee->validate($request->all());

        if($validationResult !== true) {
            return redirect('/manage')->with(['errors' => $validationResult]);
        }

        $first_name = $request['first_name'];
        $last_name = $request['last_name'];
        $address = $request['address'];
        $hiring_date = $request['hiring_date'];
        $birth_date = $request['birth_date'];
        $salary = $request['salary'];

        $employee->first_name = $first_name;
        $employee->last_name = $last_name;
        $employee->address_email = $address;
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
        $user = auth()->user();
        if((int)$id === $user->employee_id) {
            $employee = Employee::find($id);
            $employeeWorkHours = Employee_workhours::where('employee_id', $id)->get();
            $errors = '';

            if (!empty(Session::get('errors'))) {
                $errors = Session::get('errors');
            }

            return view('view_employee', ['employee' => $employee, 'employeeWorkHours' => $employeeWorkHours, 'errors' => $errors]);
        } else {
            return redirect('/view/'.$user->employee_id);
        }

    }

    /**
     * a method that shows employee edit view
     */
    public function editView($id) {
        $user = auth()->user();
        if((int)$id === $user->employee_id) {
            $employee = Employee::find($id);
            $errors = '';

            if (!empty(Session::get('errors'))) {
                $errors = Session::get('errors');
            }

            return view('edit_employee', ['employee' => $employee, 'errors' => $errors]);
        } else {
            return redirect('/edit/'.$user->employee_id);
        }
    }

    /**
     * a method that edits existing employee
     */
    public function editPost(Request $request) {
        $user = auth()->user();

        if((int)$request['id'] === $user->employee_id) {
            $employee = new Employee();

            $validationResult = $employee->validate($request->all());

            if($validationResult !== true) {
                return redirect('/edit/'.$request['id'])->with(['errors' => $validationResult]);
            }

            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $address = $request['address_email'];
            $hiring_date = $request['hiring_date'];
            $birth_date = $request['birth_date'];
            $salary = $request['salary'];

            $employee = Employee::find((int)$request['id']);
            $user = User::where('employee_id', '=', (int)$request['id'])->first();

            $employee->first_name = $first_name;
            $employee->last_name = $last_name;
            $employee->address_email = $address;
            $employee->hiring_date = $hiring_date;
            $employee->birth_date = $birth_date;
            $employee->salary = $salary;

            $user->name = $first_name;
            $user->surname = $last_name;
            $user->email = $address;

            $employee->save();
            $user->save();

            return redirect('/view/'.$request['id'])->with('success');

        } else {
            return redirect()->back();
        }
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
        $user = auth()->user();

        if((int)$id === $user->employee_id) {
            // Najpierw musimy usunąć godziny pracy danego pracownika, przez klucz obcy w bazie danych
            $employeeWorkHours = Employee_workhours::where('employee_id', $id)->get();

            if (!empty($employeeWorkHours)) {
                foreach ($employeeWorkHours as $workHour) {
                    Employee_workhours::destroy($workHour->id);
                }
            }

            $userToDelete = User::where('employee_id', '=', $user->employee_id)->first();

            User::destroy($userToDelete->id);       // Usunięcie użytkownika
            Employee::destroy($id);                 // Usunięcie pracownika

            return response()->json([
                'success' => 'Pomyślnie usunięto pracownika'
            ]);
        } else {
            return response()->json([
                'failure' => 'Nie możesz usunąć pracownika innego niż Twój'
            ]);
        }
    }
}
