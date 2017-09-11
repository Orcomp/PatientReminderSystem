@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@isset ($patient) {{ $patient->full_name }}: @endisset @lang('global.diagnoses.title')</h3>
    @can('diagnosis_create')
    <p>
        @isset($patient)
            <a href="{{ route('admin.diagnoses.create', ['patient_id' => $patient->id]) }}" class="btn btn-success">@lang('global.app_add_new')</a>
        @else
            <a href="{{ route('admin.diagnoses.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
        @endisset

    </p>
    @endcan

    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.diagnoses.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('global.app_all')</a></li> |
            <li><a href="{{ route('admin.diagnoses.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('global.app_trash')</a></li>
        </ul>
    </p>


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($diagnoses) > 0 ? 'datatable' : '' }} @can('diagnosis_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('diagnosis_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('global.diagnoses.fields.patient')</th>
                        <th>@lang('global.diagnoses.fields.diagnose-type')</th>
                        <th>@lang('global.diagnoses.fields.diagnose-date')</th>
                        <th>@lang('global.diagnoses.fields.notes')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($diagnoses) > 0)
                        @foreach ($diagnoses as $diagnosis)
                            <tr data-entry-id="{{ $diagnosis->id }}">
                                @can('diagnosis_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='patient'>{{ $diagnosis->patient->full_name or '' }}</td>
                                <td field-key='diagnose_type'>{{ $diagnosis->diagnose_type->name or '' }}</td>
                                <td field-key='diagnose_date'>{{ $diagnosis->diagnose_date }}</td>
                                <td field-key='notes'>{!! $diagnosis->notes !!}</td>
                                @if( request('show_deleted') == 1 )
                                    <td>
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'POST',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                            'route' => ['admin.diagnoses.restore', $diagnosis->id])) !!}
                                        {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                        {!! Form::close() !!}
                                        {!! Form::open(array(
                                            'style' => 'display: inline-block;',
                                            'method' => 'DELETE',
                                            'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                            'route' => ['admin.diagnoses.perma_del', $diagnosis->id])) !!}
                                        {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    </td>
                                @else
                                    <td>
                                        @can('diagnosis_view')
                                            <a href="{{ route('admin.diagnoses.show',[$diagnosis->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                        @endcan
                                        @can('diagnosis_edit')
                                            <a href="{{ route('admin.diagnoses.edit',[$diagnosis->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                        @endcan
                                        @can('diagnosis_delete')
                                            {!! Form::open(array(
                                                'style' => 'display: inline-block;',
                                                'method' => 'DELETE',
                                                'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                                'route' => ['admin.diagnoses.destroy', $diagnosis->id])) !!}
                                            {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        @can('diagnosis_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.diagnoses.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
