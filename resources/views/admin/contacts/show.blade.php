@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.contacts.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.contacts.fields.first-name')</th>
                            <td field-key='first_name'>{{ $contact->first_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.last-name')</th>
                            <td field-key='last_name'>{{ $contact->last_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.mobile-number')</th>
                            <td field-key='mobile_number'>{{ $contact->mobile_number }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.phone-number')</th>
                            <td field-key='phone_number'>{{ $contact->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.email')</th>
                            <td field-key='email'>{{ $contact->email }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.contact-type')</th>
                            <td field-key='contact_type'>{{ $contact->contact_type->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.designation-type')</th>
                            <td field-key='designation_type'>{{ $contact->designation_type->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.user')</th>
                            <td field-key='user'>{{ $contact->user->full_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.is-primary')</th>
                            <td field-key='is_primary'>{{ Form::checkbox("is_primary", 1, $contact->is_primary == 1 ? true : false, ["disabled"]) }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.patient')</th>
                            <td field-key='patient'>{{ $contact->patient->first_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.patients.fields.last-name')</th>
                            <td field-key='last_name'>{{ isset($contact->patient) ? $contact->patient->last_name : '' }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#addresses" aria-controls="addresses" role="tab" data-toggle="tab">Addresses</a></li>
<li role="presentation" class=""><a href="#appointments" aria-controls="appointments" role="tab" data-toggle="tab">Appointments</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="addresses">
<table class="table table-bordered table-striped {{ count($addresses) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.addresses.fields.contact')</th>
                        <th>@lang('global.contacts.fields.last-name')</th>
                        <th>@lang('global.addresses.fields.street')</th>
                        <th>@lang('global.addresses.fields.city')</th>
                        <th>@lang('global.addresses.fields.state')</th>
                        <th>@lang('global.addresses.fields.country')</th>
                        <th>@lang('global.addresses.fields.note')</th>
                        <th>@lang('global.addresses.fields.address-type')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($addresses) > 0)
            @foreach ($addresses as $address)
                <tr data-entry-id="{{ $address->id }}">
                    <td field-key='contact'>{{ $address->contact->first_name or '' }}</td>
<td field-key='last_name'>{{ isset($address->contact) ? $address->contact->last_name : '' }}</td>
                                <td field-key='street'>{{ $address->street }}</td>
                                <td field-key='city'>{{ $address->city->name or '' }}</td>
                                <td field-key='state'>{{ $address->state->name or '' }}</td>
                                <td field-key='country'>{{ $address->country->name or '' }}</td>
                                <td field-key='note'>{!! $address->note !!}</td>
                                <td field-key='address_type'>{{ $address->address_type->name or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.addresses.restore', $address->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.addresses.perma_del', $address->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('address_view')
                                    <a href="{{ route('admin.addresses.show',[$address->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('address_edit')
                                    <a href="{{ route('admin.addresses.edit',[$address->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('address_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.addresses.destroy', $address->id])) !!}
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
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.contacts.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
