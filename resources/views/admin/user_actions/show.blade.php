@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('global.app_view')
                </div>

                <div class="panel-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>@lang('global.user-actions.created_at')</th>
                                <th>@lang('global.user-actions.fields.user')</th>
                                <th>@lang('global.user-actions.fields.action')</th>
                                <th>@lang('global.user-actions.fields.action-object')</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr data-entry-id="{{ $user_action->id }}">
                                <td>{{ $user_action->created_at or '' }}</td>
                                <td field-key='user'>{{ $user_action->user->full_name or '' }}</td>
                                <td field-key='action'>{{ $user_action->action }}</td>
                                <td field-key='action_object'>{{ $user_action->action_object }}</td>
                            </tr>
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @if($user_action->new_values)
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @lang('global.user-actions.fields.new-values')
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            @foreach(json_decode($user_action->new_values) as $key => $value)
                            <tr>
                                <th>{{ $key }}</th>
                                <td>{{ $value }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if($user_action->old_values)
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @lang('global.user-actions.fields.old-values')
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-striped">
                            @foreach(json_decode($user_action->old_values) as $key => $value)
                            <tr>
                                <th>{{ $key }}</th>
                                <td>{{ $value }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
