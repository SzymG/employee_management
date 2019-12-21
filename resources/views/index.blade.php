@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="data-container">
                    <h3>
                        @lang('messages.welcome')
                    </h3>
                    <!-- Errors from backend validation -->
                    @if(!empty($errors))
                        <div class="alert alert-warning" role="alert">
                            @foreach(json_decode($errors) as $error)
                                @lang('messages.'.$error[0])<br>
                            @endforeach
                        </div>
                @endif
                <!-- Form to create new employee -->
                    <form action="{{route('employee.create')}}" method="post">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="">@lang('messages.name'): </label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="">@lang('messages.surname'): </label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="">@lang('messages.address'): </label>
                                <input type="text" name="address" class="form-control">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="">@lang('messages.hiringDate'): </label>
                                <input type="date" name="hiring_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="">@lang('messages.birthDate'): </label>
                                <input type="date" name="birth_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12">
                                <label for="">@lang('messages.salary'): </label>
                                <input type="number" name="salary" class="form-control" required>
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
            <div class="col-md-6">
                <div class="data-container">
                    <table class="table table-striped table-hover">
                    @if(count($employees))
                        <!-- List of employees -->
                            <tr>
                                <td>@lang('messages.name')</td>
                                <td>@lang('messages.surname')</td>
                                <td>@lang('messages.address')</td>
                                <td>@lang('messages.hiringDate')</td>
                                <td>@lang('messages.birthDate')</td>
                                <td>@lang('messages.salary')</td>
                                <td>@lang('messages.actions')</td>
                            </tr>

                            @foreach($employees as $employee)
                                <tr class="employee-row">
                                    <td>{{$employee->first_name}}</td>
                                    <td>{{$employee->last_name}}</td>
                                    <td>{{$employee->address}}</td>
                                    <td>{{$employee->hiring_date}}</td>
                                    <td>{{$employee->birth_date}}</td>
                                    <td>{{$employee->salary}}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-default btn-sm"
                                                    onclick="window.location='{{ url("view/".$employee->id) }}'">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm"
                                                    onclick="window.location='{{ url("edit/".$employee->id) }}'">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                            </button>
                                            <!-- Button HTML (to Trigger Modal) -->
                                            <a href="#deleteEmployeeModal" class="trigger-btn" data-toggle="modal">
                                                <button id="employee-delete-button" type="button" class="btn btn-default btn-sm" data-id="{{ $employee->id }}" onclick=setSelectedIdAndType($(this).data('id'),'employee')>
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </button>
                                            </a>
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
                                                            <button class="btn btn-danger delete-confirm" type="button" data-token="{{ csrf_token() }}">@lang('messages.delete')</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        <!-- When there is no employees-->
                        @else
                            <div class="alert alert-warning" role="alert">
                                @lang('messages.noEmployees')
                            </div>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
