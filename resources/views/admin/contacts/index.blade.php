@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@isset ($patient) {{ $patient->full_name }}: @endisset @lang('global.contacts.title')</h3>
    @can('contact_create')
    <p>
        @isset($patient)
            <a href="{{ route('admin.contacts.create', ['patient_id' => $patient->id]) }}" class="btn btn-success">@lang('global.app_add_new')</a>
        @else
            <a href="{{ route('admin.contacts.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
        @endisset

    </p>
    @endcan

    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.contacts.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('global.app_all')</a></li> |
            <li><a href="{{ route('admin.contacts.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('global.app_trash')</a></li>
        </ul>
    </p>


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($contacts) > 0 ? 'datatable' : '' }} @can('contact_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('contact_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>&nbsp;</th>
                        <th>@lang('global.contacts.fields.full-name')</th>
                        <th>@lang('global.contacts.fields.contact-type')</th>
                        <th>@lang('global.contacts.fields.mobile-number')</th>
                        <th>@lang('global.contacts.fields.phone-number')</th>
                        <th>@lang('global.contacts.fields.email')</th>
                        <th>@lang('global.contacts.fields.is-primary')</th>
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
                                @can('contact_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='designation_type'>{{ $contact->designation_type->name or '' }}</td>
                                <td field-key='contact_name'><a href="{{ route('admin.contacts.show', $contact->id) }}">{{ $contact->full_name }}</a></td>
                                <td field-key='contact_type'>{{ $contact->contact_type->name or '' }}</td>
                                <td field-key='mobile_number'>{{ $contact->mobile_number }}</td>
                                <td field-key='phone_number'>{{ $contact->phone_number }}</td>
                                <td field-key='email'>{{ $contact->email }}</td>
                                <td field-key='is_primary'>{{ Form::checkbox("is_primary", 1, $contact->is_primary == 1 ? true : false, ["disabled"]) }}</td>
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
@stop

@section('javascript')
    <script>
        @can('contact_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.contacts.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
