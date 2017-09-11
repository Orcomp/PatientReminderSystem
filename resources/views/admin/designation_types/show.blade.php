@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.designation-types.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.designation-types.fields.name')</th>
                            <td field-key='name'>{{ $designation_type->name }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#contacts" aria-controls="contacts" role="tab" data-toggle="tab">Contacts</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="contacts">
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

            <a href="{{ route('admin.designation_types.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
