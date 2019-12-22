@extends('layouts.app')

@section('content')
<body>
<div class="container-fluid">
    <div class="data-container">
        <div class="row">
            <div class="col-12">
                <h3>
                    @lang('messages.editEmployeeWorkHours', ['name' => $employee_full_name])
                </h3>
                <div class="flex-end-row">
                    <div class="form-group">
                        <button class="btn btn-info" onclick="window.location='{{ url("view/".$work_hours->employee_id) }}'">
                            @lang('messages.backToEmployeeView')</button>
                    </div>
                    <!-- Button to trigger modal -->
                    <div class="form-group">
                        <a href="#deleteWorkHourModal" class="trigger-btn" data-toggle="modal">
                            <button type="button" class="btn btn-danger" data-id="{{ $work_hours->id }}" onclick=setSelectedIdAndType($(this).data('id'),'work-hours')>
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
            <div class="col-12">
                <!-- Form to edit an employee workhours-->
                <form class="edit-employee-form" action="{{route('employee-work-hours.edit')}}" method="post">
                    @csrf
                    <input name="id" type="hidden" value="{{ $work_hours->id }}">
                    <input name="employee_id" type="hidden" value="{{ $work_hours->employee_id }}">
                    <div class="form-group">
                        <div class="col-12 col-md-6">
                            <label for="">@lang('messages.timeStart'): </label>
                            <input type="datetime-local" value="{{$work_hours->date_start}}" name="date_start" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-12 col-md-6">
                            <label for="">@lang('messages.timeEnd'): </label>
                            <input type="datetime-local" value="{{$work_hours->date_end}}" name="date_end" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 pt-4">
                            <button type="submit" class="btn btn-success btn-block">@lang('messages.save')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
                <button type="button" data-employee="{{ $work_hours->employee_id }}" data-token="{{ csrf_token() }}"
                        class="btn btn-danger delete-confirm">@lang('messages.delete')</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
</body>
@endsection
