@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@isset ($patient) {{ $patient->full_name }}: @endisset @lang('global.treatments.title')</h3>
    @can('treatment_create')
    <p>
        @isset($patient)
            <a href="{{ route('admin.treatments.create', ['patient_id' => $patient->id]) }}" class="btn btn-success">@lang('global.app_add_new')</a>
        @else
            <a href="{{ route('admin.treatments.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
        @endisset

    </p>
    @endcan

    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.treatments.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('global.app_all')</a></li> |
            <li><a href="{{ route('admin.treatments.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('global.app_trash')</a></li>
        </ul>
    </p>


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($treatments) > 0 ? 'datatable' : '' }} @can('treatment_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('treatment_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('global.treatments.fields.patient')</th>
                        <th>@lang('global.treatments.fields.treatment-type')</th>
                        <th>@lang('global.treatments.fields.treatment-stage')</th>
                        <th>@lang('global.treatments.fields.start-date')</th>
                        <th>@lang('global.treatments.fields.end-date')</th>
                        <th>@lang('global.treatments.fields.notes')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @if (count($treatments) > 0)
                        @foreach ($treatments as $treatment)
                            <tr data-entry-id="{{ $treatment->id }}">
                                @can('treatment_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='patient'>{{ $treatment->patient->full_name or '' }}</td>
                                <td field-key='treatment_type'>{{ $treatment->treatment_type->name or '' }}</td>
                                <td field-key='treatment_stage'>{{ $treatment->treatment_stage->name or '' }}</td>
                                <td field-key='start_date'>{{ $treatment->start_date }}</td>
                                <td field-key='end_date'>{{ $treatment->end_date }}</td>
                                <td field-key='notes'>{!! $treatment->notes !!}</td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.treatments.restore', $treatment->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.treatments.perma_del', $treatment->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('treatment_view')
                                    <a href="{{ route('admin.treatments.show',[$treatment->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('treatment_edit')
                                    <a href="{{ route('admin.treatments.edit',[$treatment->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('treatment_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.treatments.destroy', $treatment->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="11">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('treatment_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.treatments.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
