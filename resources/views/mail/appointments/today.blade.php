@component('mail::message')

# @lang('mail.appointments.greeting'), {{ $user->full_name }}!

**@lang('mail.appointments.today'):**

{!! $body !!}

**@lang('mail.appointments.upcoming')**
@component('mail::table')
| @lang('mail.appointments.table.datetime') | @lang('mail.appointments.table.days') | @lang('mail.appointments.table.patient') | @lang('mail.appointments.table.contact') |
| - | :-: | - | - |
@foreach ($upcoming as $appointment)
| {{ $appointment->appointment_time }} | {{ $appointment->diff }} | [{{ $appointment->patient->full_name ?? '' }}]({{ route('admin.patients.show', $appointment->patient->id) }}) | {{ $appointment->contacted_contact->full_name ?? '' }} |
@endforeach
@endcomponent

@lang('mail.appointments.signature'),<br>{{ config('app.name') }}

@endcomponent
