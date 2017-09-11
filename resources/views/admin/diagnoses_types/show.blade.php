@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.diagnoses-types.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.diagnoses-types.fields.name')</th>
                            <td field-key='name'>{{ $diagnoses_type->name }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#diagnoses" aria-controls="diagnoses" role="tab" data-toggle="tab">Diagnoses</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="diagnoses">
<table class="table table-bordered table-striped {{ count($diagnoses) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.diagnoses.fields.patient')</th>
                        <th>@lang('global.patients.fields.last-name')</th>
                        <th>@lang('global.diagnoses.fields.diagnose-type')</th>
                        <th>@lang('global.diagnoses.fields.diagnose-date')</th>
                        <th>@lang('global.diagnoses.fields.notes')</th>
                        @if( request('show_deleted') == 1 )
                        <th>&nbsp;</th>
                        @else
                        <th>&nbsp;</th>
                        @endif
        </tr>
    </thead>

    <tbody>
        @if (count($diagnoses) > 0)
            @foreach ($diagnoses as $diagnosis)
                <tr data-entry-id="{{ $diagnosis->id }}">
                    <td field-key='patient'>{{ $diagnosis->patient->first_name or '' }}</td>
<td field-key='last_name'>{{ isset($diagnosis->patient) ? $diagnosis->patient->last_name : '' }}</td>
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

            <p>&nbsp;</p>

            <a href="{{ route('admin.diagnoses_types.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
