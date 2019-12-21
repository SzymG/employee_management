@extends('layouts.app')
@section('content')
<body>
    <div class="container-fluid">
        <div class="data-container">
            <div class="row">
                <div>
                    <div class="flex-row">
                        <h3>
                            @lang('messages.editEmployee', ['name' => $employee->first_name.' '.$employee->last_name])
                        </h3>
                        <div class="buttons-row">
                            <div class="form-group">
                                <button class="btn btn-info" onclick="window.location='{{ url("view/".$employee->id) }}'">
                                    @lang('messages.backToView')</button>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" onclick="window.location='{{ url("/") }}'">
                                    @lang('messages.backToList')</button>
                            </div>
                            <div class="form-group">
                                <a href="#deleteEmployeeModal" class="trigger-btn" data-toggle="modal">
                                    <button type="button" class="btn btn-danger" data-id="{{ $employee->id }}" onclick=setSelectedIdAndType($(this).data('id'),'employee')>
                                        @lang('messages.delete')
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Errors from backend validation -->
                    @if(!empty($errors))
                        <div class="alert alert-warning" role="alert">
                            @foreach(json_decode($errors) as $error)
                                @lang('messages.'.$error[0])<br>
                            @endforeach
                        </div>
                    @endif
                    <!-- Form to edit an employee -->
                    <form class="edit-employee-form" action="{{route('employee.edit')}}" method="post">
                        @csrf
                        <input name="id" type="hidden" value="{{$employee->id}}">
                        <div class="form-group">
                            <div class="col-12 col-md-6">
                                <label for="">@lang('messages.name'): </label>
                                <input value="{{$employee->first_name}}" type="text" name="first_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12 col-md-6">
                                <label for="">@lang('messages.surname'): </label>
                                <input value="{{$employee->last_name}}" type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12 col-md-6">
                                <label for="">@lang('messages.address'): </label>
                                <input value="{{$employee->address}}" type="text" name="address" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12 col-md-6">
                                <label for="">@lang('messages.hiringDate'): </label>
                                <input value="{{$employee->hiring_date}}" type="date" name="hiring_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12 col-md-6">
                                <label for="">@lang('messages.birthDate'): </label>
                                <input value="{{$employee->birth_date}}" type="date" name="birth_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12 col-md-6">
                                <label for="">@lang('messages.salary'): </label>
                                <input value="{{$employee->salary}}" type="number" name="salary" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success btn-block">@lang('messages.save')</button>
                            </div>
                        </div>
                    </form>
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
                    <button type="button" data-token="{{ csrf_token() }}"
                            class="btn btn-danger delete-confirm">@lang('messages.delete')</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</body>
@endsection
