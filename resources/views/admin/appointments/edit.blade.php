@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.appointments.title')</h3>

    {!! Form::model($appointment, ['method' => 'PUT', 'route' => ['admin.appointments.update', $appointment->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('patient_id', trans('global.appointments.fields.patient'), ['class' => 'control-label required']) !!}
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.patients.show', $appointment->patient_id) }}">@lang('global.app_view')</a>
                    {!! Form::select('patient_id', $patients, old('patient_id'), ['class' => 'form-control select2', 'required' => '', 'disabled' => '']) !!}
                    {{ Form::hidden('patient_id', old('patient_id')) }}
                    <p class="help-block"></p>
                    @if($errors->has('patient_id'))
                        <p class="help-block">
                            {{ $errors->first('patient_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('user_id', trans('global.appointments.fields.treating-staff'), ['class' => 'control-label']) !!}
                    {!! Form::select('user_id', $users, old('user_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('user_id'))
                        <p class="help-block">
                            {{ $errors->first('user_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('appointment_type_id', trans('global.appointments.fields.appointment-type'), ['class' => 'control-label required']) !!}
                    {!! Form::select('appointment_type_id', $appointment_types, old('appointment_type_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('appointment_type_id'))
                        <p class="help-block">
                            {{ $errors->first('appointment_type_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('appointment_time', trans('global.appointments.fields.appointment-time'), ['class' => 'control-label']) !!}
                    {!! Form::text('appointment_time', old('appointment_time'), ['class' => 'form-control datetime', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('appointment_time'))
                        <p class="help-block">
                            {{ $errors->first('appointment_time') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row" id="reschedule-reasons">
                <div class="col-xs-12 form-group">
                    {!! Form::label('reschedule_reason_id', trans('global.appointment-logs.fields.reschedule-reason'), ['class' => 'control-label']) !!}
                    {!! Form::select('reschedule_reason_id', $reasons, old('reschedule_reason_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('reschedule_reason_id'))
                        <p class="help-block">
                            {{ $errors->first('reschedule_reason_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row" id="reschedule-notes">
                <div class="col-xs-12 form-group">
                    {!! Form::label('reschedule_note', trans('global.appointment-logs.fields.note'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('reschedule_note', old('reschedule_note'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('reschedule_note'))
                        <p class="help-block">
                            {{ $errors->first('reschedule_note') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('confirmed_at', trans('global.appointments.fields.confirmed-at'), ['class' => 'control-label']) !!}
                    {!! Form::text('confirmed_at', old('confirmed_at'), ['class' => 'form-control datetime', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('confirmed_at'))
                        <p class="help-block">
                            {{ $errors->first('confirmed_at') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('contacted_contact_id', trans('global.appointments.fields.contacted-contact'), ['class' => 'control-label']) !!}
                    {!! Form::select('contacted_contact_id', $contacted_contacts, old('contacted_contact_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('contacted_contact_id'))
                        <p class="help-block">
                            {{ $errors->first('contacted_contact_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('notes', trans('global.appointments.fields.notes'), ['class' => 'control-label']) !!}
                    {!! Form::textarea('notes', old('notes'), ['class' => 'form-control ', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('notes'))
                        <p class="help-block">
                            {{ $errors->first('notes') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{ Form::hidden('redirect_to', $redirect_to) }}
    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    @include('partials.forms.datetime')
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script>
        $(function(){
            var current_appointment = $('#appointment_time').val();
            $('#reschedule-reasons').hide();
            $('#reschedule-notes').hide();

            $('#appointment_time').on('dp.change', function(e){
                var datetime = e.date.format('{{ config('app.datetime_format_moment') }}');
                if (current_appointment !== datetime) {
                    $('#reschedule-reasons').show(400);
                    $('#reschedule-notes').show(400);
                } else {
                    $('#reschedule-reasons').hide();
                    $('#reschedule-notes').hide();
                }
            });
        });
    </script>

@stop
