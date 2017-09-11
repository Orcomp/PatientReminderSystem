<?php

namespace App\Http\Controllers\Admin;

use App\AppointmentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAppointmentLogsRequest;
use App\Http\Requests\Admin\UpdateAppointmentLogsRequest;

class AppointmentLogsController extends Controller
{
    /**
     * Display a listing of AppointmentLog.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('appointment_log_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('appointment_log_delete')) {
                return abort(401);
            }
            $appointment_logs = AppointmentLog::onlyTrashed()->get();
        } else {
            $appointment_logs = AppointmentLog::all();
        }

        return view('admin.appointment_logs.index', compact('appointment_logs'));
    }

    /**
     * Show the form for creating new AppointmentLog.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('appointment_log_create')) {
            return abort(401);
        }
        
        $appointments = \App\Appointment::get()->pluck('appointment_time', 'id')->prepend(trans('global.app_please_select'), '');
        $reschedule_reasons = \App\RescheduleReason::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.appointment_logs.create', compact('appointments', 'reschedule_reasons', 'created_bies'));
    }

    /**
     * Store a newly created AppointmentLog in storage.
     *
     * @param  \App\Http\Requests\StoreAppointmentLogsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentLogsRequest $request)
    {
        if (! Gate::allows('appointment_log_create')) {
            return abort(401);
        }
        $appointment_log = AppointmentLog::create($request->all());



        return redirect()->route('admin.appointment_logs.index');
    }


    /**
     * Show the form for editing AppointmentLog.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('appointment_log_edit')) {
            return abort(401);
        }
        
        $appointments = \App\Appointment::get()->pluck('appointment_time', 'id')->prepend(trans('global.app_please_select'), '');
        $reschedule_reasons = \App\RescheduleReason::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $created_bies = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        $appointment_log = AppointmentLog::findOrFail($id);

        return view('admin.appointment_logs.edit', compact('appointment_log', 'appointments', 'reschedule_reasons', 'created_bies'));
    }

    /**
     * Update AppointmentLog in storage.
     *
     * @param  \App\Http\Requests\UpdateAppointmentLogsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentLogsRequest $request, $id)
    {
        if (! Gate::allows('appointment_log_edit')) {
            return abort(401);
        }
        $appointment_log = AppointmentLog::findOrFail($id);
        $appointment_log->update($request->all());



        return redirect()->route('admin.appointment_logs.index');
    }


    /**
     * Display AppointmentLog.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('appointment_log_view')) {
            return abort(401);
        }
        $appointment_log = AppointmentLog::findOrFail($id);

        return view('admin.appointment_logs.show', compact('appointment_log'));
    }


    /**
     * Remove AppointmentLog from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('appointment_log_delete')) {
            return abort(401);
        }
        $appointment_log = AppointmentLog::findOrFail($id);
        $appointment_log->delete();

        return redirect()->route('admin.appointment_logs.index');
    }

    /**
     * Delete all selected AppointmentLog at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('appointment_log_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = AppointmentLog::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore AppointmentLog from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('appointment_log_delete')) {
            return abort(401);
        }
        $appointment_log = AppointmentLog::onlyTrashed()->findOrFail($id);
        $appointment_log->restore();

        return redirect()->route('admin.appointment_logs.index');
    }

    /**
     * Permanently delete AppointmentLog from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('appointment_log_delete')) {
            return abort(401);
        }
        $appointment_log = AppointmentLog::onlyTrashed()->findOrFail($id);
        $appointment_log->forceDelete();

        return redirect()->route('admin.appointment_logs.index');
    }
}
