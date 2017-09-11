<div class="panel panel-default">
    <div class="panel-heading">
        @lang('global.app_list')
    </div>

    <div class="panel-body table-responsive">
        <table class="table table-bordered table-striped {{ count($appointments) > 0 ? 'datatable' : '' }} @can('appointment_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
            <thead>
            <tr>
                @can('appointment_delete')
                    @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                @endcan

                <th>@lang('global.appointments.fields.patient')</th>
                <th>@lang('global.appointments.fields.user')</th>
                <th>@lang('global.appointments.fields.appointment-time')</th>
                <th>@lang('global.appointments.fields.appointment-type')</th>
                <th>@lang('global.appointments.fields.confirmed-at')</th>
                <th>@lang('global.appointments.fields.contacted-contact')</th>
                <th>@lang('global.appointments.fields.notes')</th>
                <th>@lang('global.appointments.fields.created-by')</th>
                @if( request('show_deleted') == 1 )
                    <th>&nbsp;</th>
                @else
                    <th>&nbsp;</th>
                @endif
            </tr>
            </thead>

            <tbody>
            @if (count($appointments) > 0)
                @foreach ($appointments as $appointment)
                    <tr data-entry-id="{{ $appointment->id }}">
                        @can('appointment_delete')
                            @if ( request('show_deleted') != 1 )<td></td>@endif
                        @endcan

                        <td field-key='patient'>{{ $appointment->patient->full_name or '' }}</td>
                        <td field-key='user'>{{ $appointment->user->full_name or '' }}</td>
                        <td field-key='appointment_time'>{{ $appointment->appointment_time }}</td>
                        <td field-key='appointment_type'>{{ $appointment->appointment_type->name }}</td>
                        <td field-key='confirmed_at'>{{ $appointment->confirmed_at }}</td>
                        <td field-key='contacted_contact'>{{ $appointment->contacted_contact->full_name or '' }}</td>
                        <td field-key='notes'>{!! $appointment->notes !!}</td>
                        <td field-key='created_by'>{{ $appointment->created_by->full_name or '' }}</td>
                        @if( request('show_deleted') == 1 )
                            <td>
                                {!! Form::open(array(
                                    'style' => 'display: inline-block;',
                                    'method' => 'POST',
                                    'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                    'route' => ['admin.appointments.restore', $appointment->id])) !!}
                                {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                {!! Form::close() !!}
                                {!! Form::open(array(
                                    'style' => 'display: inline-block;',
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                    'route' => ['admin.appointments.perma_del', $appointment->id])) !!}
                                {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                {!! Form::close() !!}
                            </td>
                        @else
                            <td>
                                @can('appointment_view')
                                    <a href="{{ route('admin.appointments.show',[$appointment->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                @endcan
                                @can('appointment_edit')
                                    <a href="{{ route('admin.appointments.edit',[$appointment->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                @endcan
                                @can('appointment_delete')
                                    {!! Form::open(array(
                                    'style' => 'display: inline-block;',
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                    'route' => ['admin.appointments.destroy', $appointment->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </td>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="12">@lang('global.app_no_entries_in_table')</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
