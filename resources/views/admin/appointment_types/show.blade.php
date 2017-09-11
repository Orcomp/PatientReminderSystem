@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.appointment-types.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.appointment-types.fields.name')</th>
                            <td field-key='name'>{{ $appointment_type->name }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <a href="{{ route('admin.appointment_types.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
