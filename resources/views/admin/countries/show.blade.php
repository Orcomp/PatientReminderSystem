@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.countries.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.countries.fields.name')</th>
                            <td field-key='name'>{{ $country->name }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#states" aria-controls="states" role="tab" data-toggle="tab">States</a></li>
<li role="presentation" class=""><a href="#cities" aria-controls="cities" role="tab" data-toggle="tab">Cities</a></li>
<li role="presentation" class=""><a href="#addresses" aria-controls="addresses" role="tab" data-toggle="tab">Addresses</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="states">
<table class="table table-bordered table-striped {{ count($states) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.states.fields.name')</th>
                        <th>@lang('global.states.fields.country')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($states) > 0)
            @foreach ($states as $state)
                <tr data-entry-id="{{ $state->id }}">
                    <td field-key='name'>{{ $state->name }}</td>
                                <td field-key='country'>{{ $state->country->name or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.states.restore', $state->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.states.perma_del', $state->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('state_view')
                                    <a href="{{ route('admin.states.show',[$state->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('state_edit')
                                    <a href="{{ route('admin.states.edit',[$state->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('state_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.states.destroy', $state->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
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
<div role="tabpanel" class="tab-pane " id="cities">
<table class="table table-bordered table-striped {{ count($cities) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.cities.fields.name')</th>
                        <th>@lang('global.cities.fields.country')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($cities) > 0)
            @foreach ($cities as $city)
                <tr data-entry-id="{{ $city->id }}">
                    <td field-key='name'>{{ $city->name }}</td>
                                <td field-key='country'>{{ $city->country->name or '' }}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.cities.restore', $city->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.cities.perma_del', $city->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('city_view')
                                    <a href="{{ route('admin.cities.show',[$city->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('city_edit')
                                    <a href="{{ route('admin.cities.edit',[$city->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('city_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.cities.destroy', $city->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
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
<div role="tabpanel" class="tab-pane " id="addresses">
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
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.countries.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
