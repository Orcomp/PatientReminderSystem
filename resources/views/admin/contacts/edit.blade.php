@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.contacts.title')</h3>

    {!! Form::model($contact, ['method' => 'PUT', 'route' => ['admin.contacts.update', $contact->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('patient_id', trans('global.contacts.fields.patient'), ['class' => 'control-label required']) !!}
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.patients.show', $contact->patient_id) }}">@lang('global.app_view')</a>
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
                    {!! Form::label('first_name', trans('global.contacts.fields.first-name'), ['class' => 'control-label required']) !!}
                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('first_name'))
                        <p class="help-block">
                            {{ $errors->first('first_name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('last_name', trans('global.contacts.fields.last-name'), ['class' => 'control-label required']) !!}
                    {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('last_name'))
                        <p class="help-block">
                            {{ $errors->first('last_name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('mobile_number', trans('global.contacts.fields.mobile-number'), ['class' => 'control-label']) !!}
                    {!! Form::text('mobile_number', old('mobile_number'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('mobile_number'))
                        <p class="help-block">
                            {{ $errors->first('mobile_number') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('phone_number', trans('global.contacts.fields.phone-number'), ['class' => 'control-label']) !!}
                    {!! Form::text('phone_number', old('phone_number'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('phone_number'))
                        <p class="help-block">
                            {{ $errors->first('phone_number') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('email', trans('global.contacts.fields.email'), ['class' => 'control-label']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('email'))
                        <p class="help-block">
                            {{ $errors->first('email') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('contact_type_id', trans('global.contacts.fields.contact-type'), ['class' => 'control-label']) !!}
                    {!! Form::select('contact_type_id', $contact_types, old('contact_type_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('contact_type_id'))
                        <p class="help-block">
                            {{ $errors->first('contact_type_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('designation_type_id', trans('global.contacts.fields.designation-type'), ['class' => 'control-label']) !!}
                    {!! Form::select('designation_type_id', $designation_types, old('designation_type_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('designation_type_id'))
                        <p class="help-block">
                            {{ $errors->first('designation_type_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('is_primary', trans('global.contacts.fields.is-primary'), ['class' => 'control-label']) !!}
                    {!! Form::hidden('is_primary', 0) !!}
                    {!! Form::checkbox('is_primary', 1, old('is_primary'), []) !!}
                    <p class="help-block"></p>
                    @if($errors->has('is_primary'))
                        <p class="help-block">
                            {{ $errors->first('is_primary') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

