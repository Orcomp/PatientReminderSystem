@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.settings.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($settings) > 0 ? 'datatable' : '' }} ">
                <thead>
                    <tr>
                        <th>@lang('global.settings.fields.key')</th>
                        <th>@lang('global.settings.fields.value')</th>
                        <th>@lang('global.app_actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($settings) > 0)
                        @foreach ($settings as $setting)
                            <tr data-entry-id="{{ $setting->id }}">
                                <td field-key='key'>{{ $setting->key }}</td>
                                <td field-key='value'>{{ $setting->value }}</td>
                                <td>
                                    @can('settings_edit')
                                        <a href="{{ route('admin.settings.edit',[$setting->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                </td>
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
    </div>
@stop

@section('javascript')

@endsection
