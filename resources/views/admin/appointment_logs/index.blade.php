@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.appointment-logs.title')</h3>
    @can('appointment_log_create')
    <p>
        <a href="{{ route('admin.appointment_logs.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>

    </p>
    @endcan

    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.appointment_logs.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('global.app_all')</a></li> |
            <li><a href="{{ route('admin.appointment_logs.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('global.app_trash')</a></li>
        </ul>
    </p>


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($appointment_logs) > 0 ? 'datatable' : '' }} @can('appointment_log_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('appointment_log_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

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
                                @can('appointment_log_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='appointment'>{{ $appointment_log->appointment->appointment_time or '' }}</td>
                                <td field-key='appointment_time'>{{ $appointment_log->appointment_time }}</td>
                                <td field-key='note'>{!! $appointment_log->note !!}</td>
                                <td field-key='reschedule_reason'>{{ $appointment_log->reschedule_reason->name or '' }}</td>
                                <td field-key='created_by'>{{ $appointment_log->created_by->full_name or '' }}</td>
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
@stop

@section('javascript')
    <script>
        @can('appointment_log_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.appointment_logs.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
