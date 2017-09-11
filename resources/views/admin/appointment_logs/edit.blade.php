@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.appointment-logs.title')</h3>

    {!! Form::model($appointment_log, ['method' => 'PUT', 'route' => ['admin.appointment_logs.update', $appointment_log->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('appointment_id', trans('global.appointment-logs.fields.appointment'), ['class' => 'control-label required']) !!}
                    {!! Form::select('appointment_id', $appointments, old('appointment_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('appointment_id'))
                        <p class="help-block">
                            {{ $errors->first('appointment_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('appointment_time', trans('global.appointment-logs.fields.appointment-time'), ['class' => 'control-label']) !!}
                    {!! Form::text('appointment_time', old('appointment_time'), ['class' => 'form-control datetime', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('appointment_time'))
                        <p class="help-block">
                            {{ $errors->first('appointment_time') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('note', trans('global.appointment-logs.fields.note'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('note', old('note'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('note'))
                        <p class="help-block">
                            {{ $errors->first('note') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('reschedule_reason_id', trans('global.appointment-logs.fields.reschedule-reason'), ['class' => 'control-label']) !!}
                    {!! Form::select('reschedule_reason_id', $reschedule_reasons, old('reschedule_reason_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('reschedule_reason_id'))
                        <p class="help-block">
                            {{ $errors->first('reschedule_reason_id') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script src="{{ url('adminlte/js') }}/timepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>    <script>
        $('.datetime').datetimepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}",
            timeFormat: "HH:mm:ss"
        });
    </script>

@stop
