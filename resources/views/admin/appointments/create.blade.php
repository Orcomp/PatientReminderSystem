@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.appointments.title')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.appointments.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('patient_id', trans('global.appointments.fields.patient'), ['class' => 'control-label required']) !!}
                    <a class="btn btn-xs btn-success" href="{{ route('admin.patients.create') }}">@lang('global.app_add_new')</a>

                    @isset($patient_id)
                    {!! Form::select('patient_id', $patients, old('patient_id'), ['class' => 'form-control select2', 'required' => '', 'disabled' => '']) !!}
                    {{ Form::hidden('patient_id', $patient_id) }}
                    @else
                    {!! Form::select('patient_id', $patients, old('patient_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    @endisset

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
                    <a class="btn btn-xs btn-success" href="{{ route('admin.users.create') }}">@lang('global.app_add_new')</a>
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
                    {!! Form::text('appointment_time', old('appointment_time') ?? $appointment_time, ['class' => 'form-control datetime', 'placeholder' => '']) !!}
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
                    <a class="btn btn-xs btn-success" href="{{ route('admin.contacts.create') }}">@lang('global.app_add_new')</a>
                    {!! Form::select('contacted_contact_id', ['' => ''], old('contacted_contact_id'), ['class' => 'form-control select2']) !!}
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
    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    @include('partials.forms.datetime')
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
    <script>
    $(function(){
        $('#patient_id').select2({
            placeholder: '{{ trans('global.appointments.placeholders.patient') }}',
        });
        $('#contacted_contact_id').select2({
            placeholder: '{{ trans('global.appointments.placeholders.patient') }}',
        });

        $('#patient_id').on('change', function(){
            var patient_id = $(this).val();

            $('#contacted_contact_id').select2({
                placeholder: '{{ trans('global.appointments.placeholders.contact') }}',
                ajax: {
                    url: '{{ route('api.contacts') }}/' + patient_id,
                    delay: 250,
                    cache: true,
                    data: function(params) {
                        return {
                            q: params.term,
                        }
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(obj){
                                return { id: obj.id, text: obj.full_name };
                            })
                        }
                    },
                },
            });
        });

        // condition if patient_id is populated
        @isset($patient_id)
        $('#patient_id').trigger('change');
        @endisset
    });
    </script>

@stop
