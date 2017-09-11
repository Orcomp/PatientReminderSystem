@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.addresses.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.addresses.fields.contact')</th>
                            <td field-key='contact'>{{ $address->contact->first_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.last-name')</th>
                            <td field-key='last_name'>{{ isset($address->contact) ? $address->contact->last_name : '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.addresses.fields.street')</th>
                            <td field-key='street'>{{ $address->street }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.addresses.fields.city')</th>
                            <td field-key='city'>{{ $address->city->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.addresses.fields.state')</th>
                            <td field-key='state'>{{ $address->state->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.addresses.fields.country')</th>
                            <td field-key='country'>{{ $address->country->name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.addresses.fields.note')</th>
                            <td field-key='note'>{!! $address->note !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.addresses.fields.address-type')</th>
                            <td field-key='address_type'>{{ $address->address_type->name or '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.addresses.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
