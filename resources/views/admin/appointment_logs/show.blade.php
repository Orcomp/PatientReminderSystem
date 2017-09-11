@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.appointment-logs.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.appointment-logs.fields.appointment')</th>
                            <td field-key='appointment'>{{ $appointment_log->appointment->appointment_time or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointment-logs.fields.appointment-time')</th>
                            <td field-key='appointment_time'>{{ $appointment_log->appointment_time }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointment-logs.fields.note')</th>
                            <td field-key='note'>{!! $appointment_log->note !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointment-logs.fields.reschedule-reason')</th>
                            <td field-key='reschedule_reason'>{{ $appointment_log->reschedule_reason->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointment-logs.fields.created-by')</th>
                            <td field-key='created_by'>{{ $appointment_log->created_by->full_name or '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.appointment_logs.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
