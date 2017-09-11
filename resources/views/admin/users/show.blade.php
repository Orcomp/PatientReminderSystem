@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.users.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.users.fields.full_name')</th>
                            <td field-key='name'>{{ $user->full_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.users.fields.email')</th>
                            <td field-key='email'>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.users.fields.role')</th>
                            <td field-key='role'>
                                @foreach ($user->role as $singleRole)
                                    <span class="label label-info label-many">{{ $singleRole->title }}</span>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#useractions" aria-controls="useractions" role="tab" data-toggle="tab">User actions</a></li>
<li role="presentation" class=""><a href="#appointments" aria-controls="appointments" role="tab" data-toggle="tab">Appointments</a></li>
<li role="presentation" class=""><a href="#appointmentlogs" aria-controls="appointmentlogs" role="tab" data-toggle="tab">Appointment logs</a></li>
<li role="presentation" class=""><a href="#appointments" aria-controls="appointments" role="tab" data-toggle="tab">Appointments</a></li>
<li role="presentation" class=""><a href="#contacts" aria-controls="contacts" role="tab" data-toggle="tab">Contacts</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="useractions">
<table class="table table-bordered table-striped {{ count($user_actions) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.user-actions.created_at')</th>
                        <th>@lang('global.user-actions.fields.user')</th>
                        <th>@lang('global.user-actions.fields.action')</th>
                        <th>@lang('global.user-actions.fields.action-model')</th>
                        <th>@lang('global.user-actions.fields.action-id')</th>

        </tr>
    </thead>

    <tbody>
        @if (count($user_actions) > 0)
            @foreach ($user_actions as $user_action)
                <tr data-entry-id="{{ $user_action->id }}">
                    <td>{{ $user_action->created_at or '' }}</td>
                                <td field-key='user'>{{ $user_action->user->full_name or '' }}</td>
                                <td field-key='action'>{{ $user_action->action }}</td>
                                <td field-key='action_model'>{{ $user_action->action_model }}</td>
                                <td field-key='action_id'>{{ $user_action->action_id }}</td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">@lang('global.app_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
<div role="tabpanel" class="tab-pane " id="appointments">
<table class="table table-bordered table-striped {{ count($appointments) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.appointments.fields.patient')</th>
                        <th>@lang('global.patients.fields.last-name')</th>
                        <th>@lang('global.appointments.fields.user')</th>
                        <th>@lang('global.appointments.fields.appointment-time')</th>
                        <th>@lang('global.appointments.fields.confirmed-at')</th>
                        <th>@lang('global.appointments.fields.contacted-contact')</th>
                        <th>@lang('global.contacts.fields.last-name')</th>
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
                    <td field-key='patient'>{{ $appointment->patient->first_name or '' }}</td>
                    <td field-key='last_name'>{{ isset($appointment->patient) ? $appointment->patient->last_name : '' }}</td>
                    <td field-key='user'>{{ $appointment->user->full_name or '' }}</td>
                    <td field-key='appointment_time'>{{ $appointment->appointment_time }}</td>
                    <td field-key='confirmed_at'>{{ $appointment->confirmed_at }}</td>
                    <td field-key='contacted_contact'>{{ $appointment->contacted_contact->first_name or '' }}</td>
                    <td field-key='last_name'>{{ isset($appointment->contacted_contact) ? $appointment->contacted_contact->last_name : '' }}</td>
                    <td field-key='notes'>{!! $appointment->notes !!}</td>
                    <td field-key='created_by'>{{ $appointment->created_by->name or '' }}</td>
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
<div role="tabpanel" class="tab-pane " id="appointmentlogs">
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
<div role="tabpanel" class="tab-pane " id="appointments">
<table class="table table-bordered table-striped {{ count($appointments) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.appointments.fields.patient')</th>
                        <th>@lang('global.patients.fields.last-name')</th>
                        <th>@lang('global.appointments.fields.user')</th>
                        <th>@lang('global.appointments.fields.appointment-time')</th>
                        <th>@lang('global.appointments.fields.confirmed-at')</th>
                        <th>@lang('global.appointments.fields.contacted-contact')</th>
                        <th>@lang('global.contacts.fields.last-name')</th>
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
                    <td field-key='patient'>{{ $appointment->patient->first_name or '' }}</td>
<td field-key='last_name'>{{ isset($appointment->patient) ? $appointment->patient->last_name : '' }}</td>
                                <td field-key='user'>{{ $appointment->user->full_name or '' }}</td>
                                <td field-key='appointment_time'>{{ $appointment->appointment_time }}</td>
                                <td field-key='confirmed_at'>{{ $appointment->confirmed_at }}</td>
                                <td field-key='contacted_contact'>{{ $appointment->contacted_contact->first_name or '' }}</td>
<td field-key='last_name'>{{ isset($appointment->contacted_contact) ? $appointment->contacted_contact->last_name : '' }}</td>
                                <td field-key='notes'>{!! $appointment->notes !!}</td>
                                <td field-key='created_by'>{{ $appointment->created_by->name or '' }}</td>
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
<div role="tabpanel" class="tab-pane " id="contacts">
<table class="table table-bordered table-striped {{ count($contacts) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.contacts.fields.first-name')</th>
                        <th>@lang('global.contacts.fields.last-name')</th>
                        <th>@lang('global.contacts.fields.mobile-number')</th>
                        <th>@lang('global.contacts.fields.phone-number')</th>
                        <th>@lang('global.contacts.fields.email')</th>
                        <th>@lang('global.contacts.fields.contact-type')</th>
                        <th>@lang('global.contacts.fields.designation-type')</th>
                        <th>@lang('global.contacts.fields.user')</th>
                        <th>@lang('global.contacts.fields.is-primary')</th>
                        <th>@lang('global.contacts.fields.patient')</th>
                        <th>@lang('global.patients.fields.last-name')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($contacts) > 0)
            @foreach ($contacts as $contact)
                <tr data-entry-id="{{ $contact->id }}">
                    <td field-key='first_name'>{{ $contact->first_name }}</td>
                                <td field-key='last_name'>{{ $contact->last_name }}</td>
                                <td field-key='mobile_number'>{{ $contact->mobile_number }}</td>
                                <td field-key='phone_number'>{{ $contact->phone_number }}</td>
                                <td field-key='email'>{{ $contact->email }}</td>
                                <td field-key='contact_type'>{{ $contact->contact_type->name or '' }}</td>
                                <td field-key='designation_type'>{{ $contact->designation_type->name or '' }}</td>
                                <td field-key='user'>{{ $contact->user->full_name or '' }}</td>
                                <td field-key='is_primary'>{{ Form::checkbox("is_primary", 1, $contact->is_primary == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='patient'>{{ $contact->patient->first_name or '' }}</td>
<td field-key='last_name'>{{ isset($contact->patient) ? $contact->patient->last_name : '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.contacts.restore', $contact->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.contacts.perma_del', $contact->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('contact_view')
                                    <a href="{{ route('admin.contacts.show',[$contact->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('contact_edit')
                                    <a href="{{ route('admin.contacts.edit',[$contact->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('contact_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.contacts.destroy', $contact->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="15">@lang('global.app_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.users.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
