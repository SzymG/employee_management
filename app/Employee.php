<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Employee extends Model
{
    private $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'address' => 'string',
        'hiring_date' => 'required|date',
        'birth_date' => 'required|date',
        'salary' => 'required|numeric',
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
