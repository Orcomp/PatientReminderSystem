@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.treatment-stages.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.treatment-stages.fields.name')</th>
                            <td field-key='name'>{{ $treatment_stage->name }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#treatments" aria-controls="treatments" role="tab" data-toggle="tab">Treatments</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="treatments">
<table class="table table-bordered table-striped {{ count($treatments) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('global.treatments.fields.patient')</th>
                        <th>@lang('global.patients.fields.last-name')</th>
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
                    <td field-key='patient'>{{ $treatment->patient->first_name or '' }}</td>
<td field-key='last_name'>{{ isset($treatment->patient) ? $treatment->patient->last_name : '' }}</td>
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

            <p>&nbsp;</p>

            <a href="{{ route('admin.treatment_stages.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>
@stop
