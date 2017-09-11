@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.user-actions.title')</h3>
    @can('user_action_create')
    <p>
    </p>
    @endcan

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($user_actions) > 0 ? 'datatable' : '' }} ">
                <thead>
                    <tr>
                        <th>@lang('global.user-actions.created_at')</th>
                        <th>@lang('global.user-actions.fields.user')</th>
                        <th>@lang('global.user-actions.fields.action')</th>
                        <th>@lang('global.user-actions.fields.action-object')</th>
                        <th>@lang('global.app_actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($user_actions) > 0)
                        @foreach ($user_actions as $user_action)
                            <tr data-entry-id="{{ $user_action->id }}">
                                <td>{{ $user_action->created_at or '' }}</td>
                                <td field-key='user'>{{ $user_action->user->full_name or '' }}</td>
                                <td field-key='action'>{{ $user_action->action }}</td>
                                <td field-key='action_object'>{{ $user_action->action_object }}</td>
                                <td>
                                    @can('user_action_view')
                                        <a href="{{ route('admin.user_actions.show',[$user_action->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
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
    <script>

    </script>
@endsection
