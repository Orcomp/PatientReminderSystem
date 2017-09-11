@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.settings.title'): {{ $setting->key }}</h3>

    {!! Form::model($setting, ['method' => 'PUT', 'route' => ['admin.settings.update', $setting->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('value', trans('global.settings.fields.value'), ['class' => 'control-label required']) !!}
                    {!! Form::text('value', old('value'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('value'))
                        <p class="help-block">
                            {{ $errors->first('value') }}
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

