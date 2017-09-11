@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.reschedule-reasons.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.reschedule-reasons.fields.name')</th>
                            <td field-key='name'>{{ $reschedule_reason->name }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#appointmentlogs" aria-controls="appointmentlogs" role="tab" data-toggle="tab">Appointment logs</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="appointmentlogs">
<table class="table table-bordered table-striped {{ count($appointment_logs) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.appointment-logs.fields.appointment')</th>
                        <th>@lang('global.appointment-logs.fields.appointment-time')</th>
                        <th>@lang('global.appointment-logs.fields.note')</th>
                        <th>@lang('global.appointment-logs.fields.reschedule-reason')</th>
                        <th>@lang('global.appointment-logs.fields.created-by')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($appointment_logs) > 0)
            @foreach ($appointment_logs as $appointment_log)
                <tr data-entry-id="{{ $appointment_log->id }}">
                    <td field-key='appointment'>{{ $appointment_log->appointment->appointment_time or '' }}</td>
                                <td field-key='appointment_time'>{{ $appointment_log->appointment_time }}</td>
                                <td field-key='note'>{!! $appointment_log->note !!}</td>
                                <td field-key='reschedule_reason'>{{ $appointment_log->reschedule_reason->name or '' }}</td>
                                <td field-key='created_by'>{{ $appointment_log->created_by->name or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.appointment_logs.restore', $appointment_log->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.appointment_logs.perma_del', $appointment_log->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('appointment_log_view')
                                    <a href="{{ route('admin.appointment_logs.show',[$appointment_log->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('appointment_log_edit')
                                    <a href="{{ route('admin.appointment_logs.edit',[$appointment_log->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('appointment_log_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.appointment_logs.destroy', $appointment_log->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="10">@lang('global.app_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.reschedule_reasons.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
