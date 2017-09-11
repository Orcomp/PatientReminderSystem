@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.appointments.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('global.appointments.fields.patient')</th>
                            <td field-key='patient'>{{ $appointment->patient->full_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointments.fields.user')</th>
                            <td field-key='user'>{{ $appointment->user->full_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointments.fields.appointment-time')</th>
                            <td field-key='appointment_time'>{{ $appointment->appointment_time }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointments.fields.confirmed-at')</th>
                            <td field-key='confirmed_at'>{{ $appointment->confirmed_at }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointments.fields.contacted-contact')</th>
                            <td field-key='contacted_contact'>{{ $appointment->contacted_contact->first_name or '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.contacts.fields.last-name')</th>
                            <td field-key='last_name'>{{ isset($appointment->contacted_contact) ? $appointment->contacted_contact->last_name : '' }}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointments.fields.notes')</th>
                            <td field-key='notes'>{!! $appointment->notes !!}</td>
                        </tr>
                        <tr>
                            <th>@lang('global.appointments.fields.created-by')</th>
                            <td field-key='created_by'>{{ $appointment->created_by->full_name or '' }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">

<li role="presentation" class="active"><a href="#appointmentlogs" aria-controls="appointmentlogs" role="tab" data-toggle="tab">Appointment logs</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

<div role="tabpanel" class="tab-pane active" id="appointmentlogs">
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>@lang('global.appointment-logs.fields.appointment-time')</th>
            <th>@lang('global.appointment-logs.fields.note')</th>
            <th>@lang('global.appointment-logs.fields.reschedule-reason')</th>
            <th>@lang('global.appointment-logs.fields.created-by')</th>
        </tr>
    </thead>

    <tbody>
        @if (count($appointment_logs) > 0)
            @foreach ($appointment_logs as $appointment_log)
                <tr data-entry-id="{{ $appointment_log->id }}">
                    <td field-key='appointment_time'>{{ $appointment_log->appointment_time }}</td>
                    <td field-key='note'>{!! $appointment_log->note !!}</td>
                    <td field-key='reschedule_reason'>{{ $appointment_log->reschedule_reason->name or '' }}</td>
                    <td field-key='created_by'>{{ $appointment_log->created_by->full_name or '' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4">@lang('global.app_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <button id="back_to_list" class="btn btn-default">@lang('global.app_back_to_list')</button>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $("#back_to_list").click(function(event) {
            event.preventDefault();
            history.back(1);
        });
    </script>
@endsection