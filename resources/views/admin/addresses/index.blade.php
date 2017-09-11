@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.addresses.title')</h3>
    @can('address_create')
    <p>
        <a href="{{ route('admin.addresses.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
        
    </p>
    @endcan

    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.addresses.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('global.app_all')</a></li> |
            <li><a href="{{ route('admin.addresses.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('global.app_trash')</a></li>
        </ul>
    </p>
    

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($addresses) > 0 ? 'datatable' : '' }} @can('address_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('address_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

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
                                @can('address_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

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
    </div>
@stop

@section('javascript') 
    <script>
        @can('address_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.addresses.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection