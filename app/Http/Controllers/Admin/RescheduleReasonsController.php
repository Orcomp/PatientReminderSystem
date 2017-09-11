<?php

namespace App\Http\Controllers\Admin;

use App\RescheduleReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRescheduleReasonsRequest;
use App\Http\Requests\Admin\UpdateRescheduleReasonsRequest;

class RescheduleReasonsController extends Controller
{
    /**
     * Display a listing of RescheduleReason.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('reschedule_reason_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('reschedule_reason_delete')) {
                return abort(401);
            }
            $reschedule_reasons = RescheduleReason::onlyTrashed()->get();
        } else {
            $reschedule_reasons = RescheduleReason::all();
        }

        return view('admin.reschedule_reasons.index', compact('reschedule_reasons'));
    }

    /**
     * Show the form for creating new RescheduleReason.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('reschedule_reason_create')) {
            return abort(401);
        }
        return view('admin.reschedule_reasons.create');
    }

    /**
     * Store a newly created RescheduleReason in storage.
     *
     * @param  \App\Http\Requests\StoreRescheduleReasonsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRescheduleReasonsRequest $request)
    {
        if (! Gate::allows('reschedule_reason_create')) {
            return abort(401);
        }
        $reschedule_reason = RescheduleReason::create($request->all());



        return redirect()->route('admin.reschedule_reasons.index');
    }


    /**
     * Show the form for editing RescheduleReason.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('reschedule_reason_edit')) {
            return abort(401);
        }
        $reschedule_reason = RescheduleReason::findOrFail($id);

        return view('admin.reschedule_reasons.edit', compact('reschedule_reason'));
    }

    /**
     * Update RescheduleReason in storage.
     *
     * @param  \App\Http\Requests\UpdateRescheduleReasonsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRescheduleReasonsRequest $request, $id)
    {
        if (! Gate::allows('reschedule_reason_edit')) {
            return abort(401);
        }
        $reschedule_reason = RescheduleReason::findOrFail($id);
        $reschedule_reason->update($request->all());



        return redirect()->route('admin.reschedule_reasons.index');
    }


    /**
     * Display RescheduleReason.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('reschedule_reason_view')) {
            return abort(401);
        }
        $appointment_logs = \App\AppointmentLog::where('reschedule_reason_id', $id)->get();

        $reschedule_reason = RescheduleReason::findOrFail($id);

        return view('admin.reschedule_reasons.show', compact('reschedule_reason', 'appointment_logs'));
    }


    /**
     * Remove RescheduleReason from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('reschedule_reason_delete')) {
            return abort(401);
        }
        $reschedule_reason = RescheduleReason::findOrFail($id);
        $reschedule_reason->delete();

        return redirect()->route('admin.reschedule_reasons.index');
    }

    /**
     * Delete all selected RescheduleReason at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('reschedule_reason_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = RescheduleReason::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore RescheduleReason from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('reschedule_reason_delete')) {
            return abort(401);
        }
        $reschedule_reason = RescheduleReason::onlyTrashed()->findOrFail($id);
        $reschedule_reason->restore();

        return redirect()->route('admin.reschedule_reasons.index');
    }

    /**
     * Permanently delete RescheduleReason from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('reschedule_reason_delete')) {
            return abort(401);
        }
        $reschedule_reason = RescheduleReason::onlyTrashed()->findOrFail($id);
        $reschedule_reason->forceDelete();

        return redirect()->route('admin.reschedule_reasons.index');
    }
}
