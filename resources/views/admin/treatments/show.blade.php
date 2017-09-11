@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.treatments.title')</h3>

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
                            <td field-key='patient'>{{ $treatment->patient->first_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.patients.fields.last-name')</th>
                            <td field-key='last_name'>{{ isset($treatment->patient) ? $treatment->patient->last_name : '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.treatments.fields.treatment-type')</th>
                            <td field-key='treatment_type'>{{ $treatment->treatment_type->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.treatments.fields.treatment-stage')</th>
                            <td field-key='treatment_stage'>{{ $treatment->treatment_stage->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.treatments.fields.start-date')</th>
                            <td field-key='start_date'>{{ $treatment->start_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.treatments.fields.end-date')</th>
                            <td field-key='end_date'>{{ $treatment->end_date }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.treatments.fields.notes')</th>
                            <td field-key='notes'>{!! $treatment->notes !!}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.treatments.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
