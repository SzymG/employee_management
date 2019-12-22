<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Employee_workhours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class EmployeeWorkHoursController extends Controller
{
    /**
     * a method that creates new employee work hours
     */
    public function create(Request $request) {
        $employeeWorkHours = new Employee_workhours();

        $timeStart = strtotime($request['date_start']);
        $date_start = date('Y-m-d:H:i:s', $timeStart);

        $timeEnd = strtotime($request['date_end']);
        $date_end = date('Y-m-d:H:i:s', $timeEnd);

        $employee_id = $request['employee_id'];

        $validationResult = $employeeWorkHours->validate($request->all());

        if($request['date_end'] < $request['date_start']){
            $validationResult = '{"datetime_error":["The date end must be a date after date start."]}';
        }

        if($validationResult !== true) {
            return redirect('/view/'.$request['employee_id'])->with(['errors' => $validationResult]);
        }

        $employeeWorkHours->date_start = $date_start;
        $employeeWorkHours->date_end = $date_end;
        $employeeWorkHours->employee_id = $employee_id;

        $employeeWorkHours->save();

        return redirect()->back();
    }

    /**
     * a method that delete an employee work hours basing on it's $id
     */
    public function destroy($id)
    {
        Employee_workhours::destroy($id);

        return response()->json([
            'success' => 'Record has been deleted successfully!'
        ]);
    }

    /**
     * a method that shows employee work hours edit view
     */
    public function editView($id) {
        $user = auth()->user();
        $employeeWorkHours = Employee_workhours::where('employee_id', '=', $user->employee_id)->get();
        $isPrivileged = false;
        foreach($employeeWorkHours as $workHour) {
            if($workHour->id === (int)$id) {
                $isPrivileged = true;
                break;
            }
        }

        if($isPrivileged) {
            $work_hours = Employee_workhours::find($id);
            $work_hours->date_start = date('Y-m-d\TH:i', strtotime($work_hours->date_start));
            $work_hours->date_end = date('Y-m-d\TH:i', strtotime($work_hours->date_end));

            $employee = Employee::find($work_hours->employee_id);
            $employeeName = $employee->first_name.' '.$employee->last_name;

            $errors = '';

            if (!empty(Session::get('errors'))) {
                $errors = Session::get('errors');
            }

            return view('edit_employee_work_hours', ['work_hours' => $work_hours, 'employee_full_name' => $employeeName, 'errors' => $errors]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * a method that edits existing employee work hours
     */
    public function editPost(Request $request) {
        $user = auth()->user();
        $employeeWorkHours = Employee_workhours::where('employee_id', '=', $user->employee_id)->get();
        $isPrivileged = false;
        foreach($employeeWorkHours as $workHour) {
            if($workHour->id === (int)$request['id']) {
                $isPrivileged = true;
                break;
            }
        }

        if($isPrivileged) {
            $employee_work_hours = Employee_workhours::find((int)$request['id']);

            $employee_id = $request['employee_id'];
            $date_start = $request['date_start'];
            $date_end = $request['date_end'];

            $validationResult = $employee_work_hours->validate($request->all());

            if($request['date_end'] < $request['date_start']){
                $validationResult = '{"datetime_error":["The date end must be a date after date start."]}';
            }

            if($validationResult !== true) {
                return redirect('/employee-work-hours/edit/'.$request['id'])->with(['errors' => $validationResult]);
            }

            $employee_work_hours->employee_id = $employee_id;
            $employee_work_hours->date_start = $date_start;
            $employee_work_hours->date_end = $date_end;

            $employee_work_hours->save();

            return redirect('/view/'.$employee_id)->with('success');
        } else {
            return redirect()->back();
        }
    }
}
