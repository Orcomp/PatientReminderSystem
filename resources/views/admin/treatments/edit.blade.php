@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.treatments.title')</h3>

    {!! Form::model($treatment, ['method' => 'PUT', 'route' => ['admin.treatments.update', $treatment->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('patient_id', trans('global.treatments.fields.patient'), ['class' => 'control-label required']) !!}
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.patients.show', $treatment->patient_id) }}">@lang('global.app_view')</a>
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
                    {!! Form::label('treatment_type_id', trans('global.treatments.fields.treatment-type'), ['class' => 'control-label']) !!}
                    {!! Form::select('treatment_type_id', $treatment_types, old('treatment_type_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('treatment_type_id'))
                        <p class="help-block">
                            {{ $errors->first('treatment_type_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('treatment_stage_id', trans('global.treatments.fields.treatment-stage'), ['class' => 'control-label']) !!}
                    {!! Form::select('treatment_stage_id', $treatment_stages, old('treatment_stage_id'), ['class' => 'form-control select2']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('treatment_stage_id'))
                        <p class="help-block">
                            {{ $errors->first('treatment_stage_id') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('start_date', trans('global.treatments.fields.start-date'), ['class' => 'control-label required']) !!}
                    {!! Form::text('start_date', old('start_date'), ['class' => 'form-control date', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('start_date'))
                        <p class="help-block">
                            {{ $errors->first('start_date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('end_date', trans('global.treatments.fields.end-date'), ['class' => 'control-label']) !!}
                    {!! Form::text('end_date', old('end_date'), ['class' => 'form-control datetime', 'placeholder' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('end_date'))
                        <p class="help-block">
                            {{ $errors->first('end_date') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('notes', trans('global.treatments.fields.notes'), ['class' => 'control-label']) !!}
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