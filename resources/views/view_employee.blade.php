@extends('layouts.app')

@section('content')

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <!-- Container with employee view -->
            <div class="data-container">
                <div class="edit-form-header">
                    <?php
                        $user = auth()->user();
                    ?>
                    <div>
                        <h3>
                            @lang('messages.viewEmployee', ['name' => $employee->first_name.' '.$employee->last_name])
                        </h3>
                    </div>
                    <div class="flex-end-row">
                        <div class="form-group">
                            <button class="btn btn-primary" onclick="window.location='{{ url("edit/".$employee->id) }}'">
                                @lang('messages.edit')</button>
                        </div>
                        <!-- Button triggered delete employee modal-->
                        <div class="form-group">
                            <a href="#deleteEmployeeModal" class="trigger-btn" data-toggle="modal">
                                <button type="button" class="btn btn-danger" data-id="{{ $employee->id }}" onclick=setSelectedIdAndType($(this).data('id'),'employee')>
                                    @lang('messages.delete')
                                </button>
                            </a>
                        </div>
                        <!-- Przycisk do powrotu na widok zarządzania pracownikami, w przyszłości jeśli chcialibyśmy poszerzyć funkcjonalność
                        aplikacji - można go odkomentować -->
{{--                        <div class="form-group">--}}
{{--                            <button class="btn btn-info" onclick="window.location='{{ url("/")}}'">--}}
{{--                                @lang('messages.backToList')</button>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <!-- Employee data -->
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">@lang('messages.name'): </label>
                        <input disabled="true" value="{{$employee->first_name}}" type="text" name="first_name" class="form-control" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">@lang('messages.surname'): </label>
                        <input disabled="true" value="{{$employee->last_name}}" type="text" name="last_name" class="form-control" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">@lang('messages.address'): </label>
                        <input disabled="true" value="{{$employee->address_email}}" type="text" name="address_email" class="form-control">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">@lang('messages.hiringDate'): </label>
                        <input disabled="true" value="{{$employee->hiring_date}}" type="date" name="hiring_date" class="form-control" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">@lang('messages.birthDate'): </label>
                        <input disabled="true" value="{{$employee->birth_date}}" type="date" name="birth_date" class="form-control" required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-md-12">
                        <label for="">@lang('messages.salary'): </label>
                        <input disabled="true" value="{{$employee->salary}}" type="number" name="salary" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Creating new employee workhours -->
            <div class="data-container">
                <div class="col-12">
                    <h3>@lang('messages.addWorkHours')</h3>
                    <!-- Errors from backend validation -->
                    @if(!empty($errors))
                        <div class="alert alert-warning" role="alert">
                            @foreach(json_decode($errors) as $error)
                                @lang('messages.'.$error[0])<br>
                            @endforeach
                        </div>
                    @endif
                    <!-- Form using to create employee work hours -->
                    <form action="{{route('employeeWorkHours.create')}}" method="post">
                        @csrf
                        <input name="employee_id" type="hidden" value="{{$employee->id}}">
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="">@lang('messages.timeStart'): </label>
                                <input type="datetime-local" name="date_start" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="">@lang('messages.timeEnd'): </label>
                                <input type="datetime-local" name="date_end" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">@lang('messages.create')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="data-container">
                <div class="col-12">
                    <h3>@lang('messages.workHours')</h3>
                    <table class="table table-striped table-hover">
                    @if(count($employeeWorkHours))
                        <!-- List of employee work hours -->
                            <tr>
                                <td>@lang('messages.timeStart')</td>
                                <td>@lang('messages.timeEnd')</td>
                                <td>@lang('messages.actions')</td>
                            </tr>

                            @foreach($employeeWorkHours as $workHour)
                                <tr class="work-hour-row">
                                    <td>{{$workHour->date_start}}</td>
                                    <td>{{$workHour->date_end}}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-default btn-sm"
                                                    onclick="window.location='{{ url("employee-work-hours/edit/".$workHour->id) }}'">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </button>
                                            <!-- Button HTML (to Trigger Modal) -->
                                            <a href="#deleteWorkHourModal" class="trigger-btn" data-toggle="modal">
                                                <button id="employee-delete-button" type="button" class="btn btn-default btn-sm"
                                                        data-id="{{ $workHour->id }}" onclick=setSelectedIdAndType($(this).data('id'),'work-hours')>
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </button>
                                            </a>
                                            <!-- Modal HTML -->
                                            <div id="deleteWorkHourModal" class="modal fade">
                                                <div class="modal-dialog modal-confirm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">@lang('messages.areYouSure')</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>@lang('messages.deleteWorkHoursMessage')</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-info" data-dismiss="modal">@lang('messages.back')</button>
                                                            <button class="btn btn-danger delete-confirm" type="button" data-employee="{{ $employee->id }}" data-token="{{ csrf_token() }}">@lang('messages.delete')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        <!-- When there is no work hours-->
                        @else
                            <div class="alert alert-warning" role="alert">
                                @lang('messages.noWorkHours')
                            </div>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal HTML -->
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('messages.areYouSure')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>@lang('messages.deleteEmployeeMessage')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">@lang('messages.back')</button>
                    <button type="button" data-token="{{ csrf_token() }}" class="btn btn-danger delete-confirm">@lang('messages.delete')</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</body>
@endsection
