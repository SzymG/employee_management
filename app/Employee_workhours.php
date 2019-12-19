<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Employee_workhours extends Model
{
    private $rules = [
        'date_start' => 'required|string',
        'date_end' => 'required|string',
        'employee_id' => 'required',
    ];

    public function validate($data) {
        $validator = Validator::make($data, $this->rules);
        if($validator->passes()) {
            return true;
        } else {
            return $validator->errors();
        }
    }
}
