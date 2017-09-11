@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@isset ($patient) {{ $patient->full_name }}: @endisset @lang('global.appointments.title')</h3>

    <div class="row">
        <div class="col-md-4 text-left">
            @can('appointment_create')
            <p>
                @isset($patient)
                    <a href="{{ route('admin.appointments.create', ['patient_id' => $patient->id]) }}" class="btn btn-success">@lang('global.app_add_new')</a>
                @else
                    <a href="{{ route('admin.appointments.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
                @endisset
            </p>
            @endcan
        </div>
        <div class="col-md-8 text-right">
            <ul class="list-inline">
                <li><a href="{{ route('admin.appointments.index') }}?view=calendar" style="{{ request('view', 'calendar') == 'calendar' ? 'font-weight: 700' : '' }}">@lang('global.appointments.view-calendar')</a></li> |
                <li><a href="{{ route('admin.appointments.index') }}?view=list" style="{{ request('view') == 'list' ? 'font-weight: 700' : '' }}">@lang('global.appointments.view-list')</a></li>
            </ul>

            <form action="{{ route('admin.appointments.index') }}" method="get">
                <input type="hidden" name="view" value="{{ request('view', 'calendar') }}" />
                <b>@lang('global.appointments.filter-by-staff'):</b>
                <div class="row">
                    <div class="col-md-4 col-md-offset-8">
                        <select class="form-control select2" multiple="multiple" required="" name="staff[]">
                            <option value="-1" @if(in_array('-1', $staff_filter)) selected @endif>@lang('global.appointments.filters.staff')</option>
                            <option value="-2" @if(in_array('-2', $staff_filter)) selected @endif>@lang('global.appointments.filters.doctors')</option>
                            <option value="-3" @if(in_array('-3', $staff_filter)) selected @endif>@lang('global.appointments.filters.nurses')</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                @if(in_array($user->id, $staff_filter))
                                    selected
                                @endif
                                >
                                    {{ $user->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="submit" value="@lang('global.appointments.filter')" class="btn btn-sm btn-info" style="margin-top: 4px" />

            </form>

        </div>
    </div>

    @if (request('view') == 'list')
        @include('admin.appointments.index_list')
    @else
        @include('admin.appointments.index_calendar')
    @endif
@stop

@section('javascript')
    @if (request('view') == 'list')
    <script>
        @can('appointment_delete')
            @if ( request('show_deleted') != 1 ) window.route_mass_crud_entries_destroy = '{{ route('admin.appointments.mass_destroy') }}'; @endif
        @endcan
    </script>
    @else
        @parent
        <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/locale/fr.js'></script>

        <script>
            $(document).ready(function () {
                // page is now ready, initialize the calendar...
                events={!! json_encode($calendar_events) !!};
                $('#calendar').fullCalendar({
                    // put your options and callbacks here
                    events: events,
                    timeFormat: 'H:mm',
                    eventAfterAllRender: function(view) {
                        $('.fc-day-top').each(function(){
                            var date = $(this).data('date');
                            @isset ($patient)
                            var html = '<a class="btn btn-success btn-xs" href="{{ route('admin.appointments.create', ['redirect_to' => url()->current(), 'patient_id' => $patient->id]) }}&date='+ date +'"><span class="fa fa-plus"></span></a>';
                            @else
                            var html = '<a class="btn btn-success btn-xs" href="{{ route('admin.appointments.create', ['redirect_to' => url()->current()]) }}&date='+ date +'"><span class="fa fa-plus"></span></a>';
                            @endisset
                            $(this).css('position','relative');
                            $(this).append(html);
                        });
                    }
                })
            });
        </script>
    @endif
@endsection
