@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.patients.title')</h3>
    @can('patient_create')
    <p>
        <a href="{{ route('admin.patients.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>

    </p>
    @endcan

    <p>
        <ul class="list-inline">
            <li><a href="{{ route('admin.patients.index') }}" style="{{ request('show_deleted') == 1 ? '' : 'font-weight: 700' }}">@lang('global.app_all')</a></li> |
            <li><a href="{{ route('admin.patients.index') }}?show_deleted=1" style="{{ request('show_deleted') == 1 ? 'font-weight: 700' : '' }}">@lang('global.app_trash')</a></li>
        </ul>
    </p>


    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($patients) > 0 ? 'datatable' : '' }} @can('patient_delete') @if ( request('show_deleted') != 1 ) dt-select @endif @endcan">
                <thead>
                    <tr>
                        @can('patient_delete')
                            @if ( request('show_deleted') != 1 )<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>@endif
                        @endcan

                        <th>@lang('global.patients.fields.first-name')</th>
                        <th>@lang('global.patients.fields.last-name')</th>
                        <th>@lang('global.patients.fields.gender')</th>
                        <th>@lang('global.patients.fields.birth-date')</th>
                        <th>@lang('global.patients.fields.schooled')</th>
                        <th>@lang('global.patients.fields.notes')</th>
                        <th>@lang('global.app_details')</th>
                        <th>@lang('global.app_actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($patients) > 0)
                        @foreach ($patients as $patient)
                            <tr data-entry-id="{{ $patient->id }}">
                                @can('patient_delete')
                                    @if ( request('show_deleted') != 1 )<td></td>@endif
                                @endcan

                                <td field-key='first_name'><a href="{{ route('admin.patients.show', $patient->id) }}">{{ $patient->first_name }}</a></td>
                                <td field-key='last_name'><a href="{{ route('admin.patients.show', $patient->id) }}">{{ $patient->last_name }}</a></td>
                                <td field-key='gender'>{{ $patient->gender }}</td>
                                <td field-key='birth_date'>{{ $patient->birth_date }}</td>
                                <td field-key='schooled'>{{ Form::checkbox("schooled", 1, $patient->schooled == 1 ? true : false, ["disabled"]) }}</td>
                                <td field-key='notes'>{!! $patient->notes !!}</td>
                                <td>
                                    @can('contact_view')
                                        <a href="{{ route('admin.contacts.index',['patient_id' => $patient->id]) }}" class="btn btn-xs btn-primary">@lang('global.contacts.title')</a>
                                    @endcan
                                    @can('diagnosis_view')
                                        <a href="{{ route('admin.diagnoses.index',['patient_id' => $patient->id]) }}" class="btn btn-xs btn-primary">@lang('global.diagnoses.title')</a>
                                    @endcan
                                    @can('treatment_view')
                                        <a href="{{ route('admin.treatments.index',['patient_id' => $patient->id]) }}" class="btn btn-xs btn-primary">@lang('global.treatments.title')</a>
                                    @endcan
                                    @can('appointment_view')
                                        <a href="{{ route('admin.appointments.index',['patient_id' => $patient->id, 'view' => 'list']) }}" class="btn btn-xs btn-primary">@lang('global.appointments.title')</a>
                                    @endcan
                                </td>
                                @if( request('show_deleted') == 1 )
                                <td>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'POST',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.patients.restore', $patient->id])) !!}
                                    {!! Form::submit(trans('global.app_restore'), array('class' => 'btn btn-xs btn-success')) !!}
                                    {!! Form::close() !!}
                                                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.patients.perma_del', $patient->id])) !!}
                                    {!! Form::submit(trans('global.app_permadel'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                                                </td>
                                @else
                                <td>
                                    @can('patient_view')
                                    <a href="{{ route('admin.patients.show',[$patient->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_view')</a>
                                    @endcan
                                    @can('patient_edit')
                                    <a href="{{ route('admin.patients.edit',[$patient->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    @endcan
                                    @can('patient_delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.patients.destroy', $patient->id])) !!}
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
        @can('patient_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.patients.mass_destroy') }}'; @endif
        @endcan

    </script>
@endsection
