@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.diagnoses.title')</h3>

    {!! Form::model($diagnosis, ['method' => 'PUT', 'route' => ['admin.diagnoses.update', $diagnosis->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('patient_id', trans('global.diagnoses.fields.patient'), ['class' => 'control-label required']) !!}
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.patients.show', $diagnosis->patient_id) }}">@lang('global.app_view')</a>
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
                    {!! Form::label('diagnose_type_id', trans('global.diagnoses.fields.diagnose-type'), ['class' => 'control-label required']) !!}
                    {!! Form::select('diagnose_type_id', $diagnose_types, old('diagnose_type_id'), ['class' => 'form-control select2', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('diagnose_type_id'))
                        <p class="help-block">
                            {{ $errors->first('diagnose_type_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('diagnose_date', trans('global.diagnoses.fields.diagnose-date'), ['class' => 'control-label']) !!}
                    {!! Form::text('diagnose_date', old('diagnose_date'), ['class' => 'form-control datetime', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('diagnose_date'))
                        <p class="help-block">
                            {{ $errors->first('diagnose_date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('notes', trans('global.diagnoses.fields.notes'), ['class' => 'control-label']) !!}
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

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    @include('partials.forms.date')
    <script>

    </script>

@stop