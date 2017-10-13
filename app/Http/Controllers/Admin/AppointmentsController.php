<?php

namespace App\Http\Controllers\Admin;

use App\Appointment;
use App\AppointmentLog;
use App\Patient;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAppointmentsRequest;
use App\Http\Requests\Admin\UpdateAppointmentsRequest;

class AppointmentsController extends Controller
{
    /**
     * Display a listing of Appointment.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::all();
        $staff_filter = array_map('intval', $request->get('staff', [Auth::id()]));

        if (in_array('-1', $staff_filter)) {
            $all_users = $users->map(function($user){
                return ['id' => $user->id];
            })->toArray();
            $staff_filter = array_merge($staff_filter, $all_users);
        }

        if (in_array('-2', $staff_filter)) {
            $all_doctors = User::whereHas('role', function($q){
                $q->where('title', 'Doctor');
            })->get(['id'])->toArray();
            $staff_filter = array_merge($staff_filter, $all_doctors);
        }

        if (in_array('-3', $staff_filter)) {
            $all_doctors = User::whereHas('role', function($q){
                $q->where('title', 'Nurse');
            })->get(['id'])->toArray();
            $staff_filter = array_merge($staff_filter, $all_doctors);
        }

        $appointments = '';
        $startDate = Carbon::now()->format(config('app.date_format'));
        $endDate = Carbon::now()->addDays(30)->format(config('app.date_format'));

        if ($request->input('daterange')) {
            try {
                $daterange = explode(' - ', $request->input('daterange'));
                $startDate = Carbon::createFromFormat('Y-m-d', $daterange[0])->format(config('app.date_format'));
                $endDate = Carbon::createFromFormat('Y-m-d', $daterange[1])->format(config('app.date_format'));
            } catch (\Exception $e) {
                $errors = [ trans('validation.date_format', ['attribute' => 'daterange', 'format' => config('app.date_format')]) ];
            }
        }

        if ($request->input('view') == 'list' && is_null($request->input('daterange'))) {
            $appointments = Appointment::ofPatient()
                ->whereIn('user_id', $staff_filter)
                ->get();
        } else {
            $appointments = Appointment::ofPatient()
                ->whereIn('user_id', $staff_filter)
                ->whereBetween('appointment_time', [$startDate, $endDate])
                ->get();
        }

        $calendar_events = [];
        foreach ($appointments as $appointment) {
            if ($appointment->appointment_time) {
                $calendar_events[] = [
                    'title' => $appointment->patient->full_name,
                    'start' => $appointment->appointment_time,
                    'url' => route('admin.appointments.edit', [$appointment->id, 'redirect_to' => url()->current()])
                ];
            }
        }

        $patient = Patient::find($request->input('patient_id'));

        return view('admin.appointments.index', compact('appointments', 'patient', 'calendar_events',
            'users', 'staff_filter'))->withErrors(isset($errors) ? $errors : []);
    }

    /**
     * Show the form for creating new Appointment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (! Gate::allows('appointment_create')) {
            return abort(401);
        }

        $appointment_types = \App\AppointmentType::get()->pluck('name', 'id');
        $patients = \App\Patient::get()->pluck('full_name', 'id')->prepend('', '');
        $users = \App\User::get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');

        $redirect_to      = $request->input('redirect_to');
        $appointment_time = $request->input('date');
        $patient_id       = $request->input('patient_id');

        return view('admin.appointments.create', compact('appointment_types', 'patients', 'users', 'redirect_to', 'appointment_time', 'patient_id'));
    }

    /**
     * Store a newly created Appointment in storage.
     *
     * @param  \App\Http\Requests\StoreAppointmentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentsRequest $request)
    {
        if (! Gate::allows('appointment_create')) {
            return abort(401);
        }
        $request['created_by_id'] = \Auth::id();
        $appointment = Appointment::create($request->all());

        if ($request->get('redirect_to')) {
            return redirect($request->get('redirect_to'));
        }

        return redirect()->back();
    }


    /**
     * Show the form for editing Appointment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (! Gate::allows('appointment_edit')) {
            return abort(401);
        }

        $appointment = Appointment::findOrFail($id);

        $appointment_types = \App\AppointmentType::get()->pluck('name', 'id');
        $patients = \App\Patient::get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');
        $reasons = \App\RescheduleReason::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $contacted_contacts = \App\Contact::where('patient_id', $appointment->patient->id)->get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');

        $redirect_to = $request->input('redirect_to');

        return view('admin.appointments.edit', compact(
            'appointment',
            'appointment_types',
            'patients',
            'users',
            'contacted_contacts',
            'reasons',
            'redirect_to'
        ));
    }

    /**
     * Update Appointment in storage.
     *
     * @param  \App\Http\Requests\UpdateAppointmentsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentsRequest $request, $id)
    {
        if (! Gate::allows('appointment_edit')) {
            return abort(401);
        }

        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        if ($request->get('reschedule_note') || $request->get('reschedule_reason_id')) {
            $appoinment_log = AppointmentLog::create([
                'appointment_id' => $appointment->id,
                'appointment_time' => $request->get('appointment_time'),
                'note' => $request->get('reschedule_note'),
                'reschedule_reason_id' => $request->get('reschedule_reason_id'),
                'created_by_id' => \Auth::id()
            ]);
        }

        if ($request->get('redirect_to')) {
            return redirect($request->get('redirect_to'));
        }

        return redirect()->route('admin.appointments.index');
    }


    /**
     * Display Appointment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('appointment_view')) {
            return abort(401);
        }

        $patients = \App\Patient::get()->pluck('first_name', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $contacted_contacts = \App\Contact::get()->pluck('first_name', 'id')->prepend(trans('global.app_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $appointment_logs = \App\AppointmentLog::where('appointment_id', $id)->get();

        $appointment = Appointment::findOrFail($id);

        return view('admin.appointments.show', compact('appointment', 'appointment_logs'));
    }


    /**
     * Remove Appointment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('appointment_delete')) {
            return abort(401);
        }
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Delete all selected Appointment at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('appointment_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Appointment::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Appointment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('appointment_delete')) {
            return abort(401);
        }
        $appointment = Appointment::onlyTrashed()->findOrFail($id);
        $appointment->restore();

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Permanently delete Appointment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('appointment_delete')) {
            return abort(401);
        }
        $appointment = Appointment::onlyTrashed()->findOrFail($id);
        $appointment->forceDelete();

        return redirect()->route('admin.appointments.index');
    }
}
