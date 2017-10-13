@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.patients.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.patients.fields.first-name')</th>
                            <th>@lang('global.patients.fields.last-name')</th>
                            <th>@lang('global.patients.fields.gender')</th>
                            <th>@lang('global.patients.fields.birth-date')</th>
                            <th>@lang('global.patients.fields.schooled')</th>
                            <th>@lang('global.patients.fields.notes')</th>
                        </tr>
                        <tr>
                            <td field-key='first_name'>{{ $patient->first_name }}</td>
                            <td field-key='last_name'>{{ $patient->last_name }}</td>
                            <td field-key='gender'>{{ $patient->gender }}</td>
                            <td field-key='birth_date'>{{ $patient->birth_date }}</td>
                            <td field-key='schooled'>{{ Form::checkbox("schooled", 1, $patient->schooled == 1 ? true : false, ["disabled"]) }}</td>
                            <td field-key='notes'>{!! $patient->notes !!}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>@lang('global.addresses.fields.address-type')</th>
                            <th>@lang('global.addresses.fields.street')</th>
                            <th>@lang('global.addresses.fields.city')</th>
                            <th>@lang('global.addresses.fields.state')</th>
                            <th>@lang('global.addresses.fields.country')</th>
                            <th>@lang('global.addresses.fields.note')</th>
                        </thead>
                        <tbody>
                            @forelse($patient->addresses as $address)
                            <tr>
                                <td>{{ $address->address_type->name }}</td>
                                <td>{{ $address->street }}</td>
                                <td>{{ $address->city ? $address->city->name : null }}</td>
                                <td>{{ $address->state ? $address->state->name : null }}</td>
                                <td>{{ $address->country ? $address->country->name : null }}</td>
                                <td>{{ $address->note }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">@lang('global.addresses.not-found')</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <a href="{{ route('admin.patients.index') }}" class="btn btn-default">@lang('global.app_back_to_list')</a>
        </div>
    </div>

    <div class="row">
        {{-- contacts panel --}}
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('global.contacts.title')
                    <a class="btn btn-success btn-xs" href="{{ route('admin.contacts.create', ['redirect_to' => url()->current(), 'patient_id' => $patient->id]) }}">@lang('global.app_add_new')</a>
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.contacts.index',['patient_id' => $patient->id]) }}">@lang('global.app_view')</a>
                </div>
                <div class="panel-body">
                    @if (count($contacts) > 0)
                        @foreach ($contacts as $contact)
                            <div class="row">
                                <div class="col-md-6">
                                    <b>@lang('global.contacts.fields.full-name')</b>: {{ $contact->designation_type->name or '' }} {{ $contact->full_name }}
                                </div>
                                <div class="col-md-6">
                                    <b>@lang('global.contacts.fields.mobile-number')</b>: {{ $contact->mobile_number }}
                                </div>
                                <div class="col-md-6">
                                    <b>@lang('global.contacts.fields.phone-number')</b>: {{ $contact->phone_number }}
                                </div>
                                <div class="col-md-6">
                                    <b>@lang('global.contacts.fields.email')</b>: {{ $contact->email }}
                                </div>
                                <div class="col-md-6">
                                    <b>@lang('global.contacts.fields.contact-type')</b>: {{ $contact->contact_type->name or '' }}
                                </div>
                                <div class="col-md-6">
                                    <b>@lang('global.contacts.fields.is-primary')</b>:
                                    @if ($contact->is_primary) @lang('global.app_yes') @else @lang('global.app_no') @endif
                                </div>
                            </div>
                            <hr />
                        @endforeach
                    @else
                        @lang('global.app_no_entries_in_table')
                    @endif
                </div>
            </div>
        </div>
        {{-- contacts panel end --}}

        {{-- appointments panel --}}
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('global.appointments.title')
                    <a class="btn btn-success btn-xs" href="{{ route('admin.appointments.create', ['redirect_to' => url()->current(), 'patient_id' => $patient->id]) }}">@lang('global.app_add_new')</a>
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.appointments.index',['patient_id' => $patient->id, 'view' => 'list']) }}">@lang('global.app_view')</a>
                </div>

                <div class="panel-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>@lang('global.appointments.fields.user')</th>
                                <th>@lang('global.appointments.fields.appointment-start-time')</th>
                                <th>@lang('global.appointments.fields.appointment-type')</th>
                                <th>@lang('global.appointments.fields.created-by')</th>
                                @can('appointment_view')
                                <th>&nbsp;</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>
                            @if (count($appointments) > 0)
                                @foreach ($appointments as $appointment)
                                    <tr data-entry-id="{{ $appointment->id }}">
                                        <td field-key='user'>{{ $appointment->user->full_name or '' }}</td>
                                        <td field-key='appointment_time'>{{ $appointment->appointment_time }}</td>
                                        <td field-key='appointment_time'>{{ $appointment->appointment_type->name }}</td>
                                        <td field-key='created_by'>{{ $appointment->created_by->full_name or '' }}</td>
                                        @can('appointment_view')
                                        <td>
                                            <a href="{{ route('admin.appointments.show',[$appointment->id]) }}" class="btn btn-xs btn-primary">@lang('global.app_details')</a>
                                        </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12">@lang('global.app_no_entries_in_table')</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- appointments panel end --}}
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('global.treatments.title')
                    <a class="btn btn-success btn-xs" href="{{ route('admin.treatments.create', ['redirect_to' => url()->current(), 'patient_id' => $patient->id]) }}">@lang('global.app_add_new')</a>
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.treatments.index',['patient_id' => $patient->id]) }}">@lang('global.app_view')</a>
                </div>

                <div class="panel-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>@lang('global.treatments.fields.patient')</th>
                                <th>@lang('global.treatments.fields.treatment-type')</th>
                                <th>@lang('global.treatments.fields.treatment-stage')</th>
                                <th>@lang('global.treatments.fields.start-date')</th>
                                <th>@lang('global.treatments.fields.end-date')</th>
                                <th>@lang('global.treatments.fields.notes')</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (count($treatments) > 0)
                                @foreach ($treatments as $treatment)
                                    <tr data-entry-id="{{ $treatment->id }}">
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
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @lang('global.diagnoses.title')
                    <a class="btn btn-success btn-xs" href="{{ route('admin.diagnoses.create', ['redirect_to' => url()->current(), 'patient_id' => $patient->id]) }}">@lang('global.app_add_new')</a>
                    <a class="btn btn-primary btn-xs" href="{{ route('admin.diagnoses.index',['patient_id' => $patient->id]) }}">@lang('global.app_view')</a>
                </div>

                <div class="panel-body table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
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
        </div>
    </div>

@stop
