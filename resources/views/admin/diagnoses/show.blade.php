@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.diagnoses.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.patients.fields.first-name')</th>
                            <td field-key='patient'>{{ $diagnosis->patient->first_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.patients.fields.last-name')</th>
                            <td field-key='last_name'>{{ isset($diagnosis->patient) ? $diagnosis->patient->last_name : '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.diagnoses.fields.diagnose-type')</th>
                            <td field-key='diagnose_type'>{{ $diagnosis->diagnose_type->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.diagnoses.fields.diagnose-date')</th>
                            <td field-key='diagnose_date'>{{ $diagnosis->diagnose_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.diagnoses.fields.notes')</th>
                            <td field-key='notes'>{!! $diagnosis->notes !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.diagnoses.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
