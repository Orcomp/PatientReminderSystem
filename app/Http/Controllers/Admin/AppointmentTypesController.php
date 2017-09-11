<?php

namespace App\Http\Controllers\Admin;

use App\AppointmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAppointmentTypesRequest;
use App\Http\Requests\Admin\UpdateAppointmentTypesRequest;

class AppointmentTypesController extends Controller
{
    /**
     * Display a listing of AppointmentType.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('appointment_type_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('appointment_type_delete')) {
                return abort(401);
            }
            $appointment_types = AppointmentType::onlyTrashed()->get();
        } else {
            $appointment_types = AppointmentType::all();
        }

        return view('admin.appointment_types.index', compact('appointment_types'));
    }

    /**
     * Show the form for creating new AppointmentType.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('appointment_type_create')) {
            return abort(401);
        }
        return view('admin.appointment_types.create');
    }

    /**
     * Store a newly created AppointmentType in storage.
     *
     * @param  \App\Http\Requests\StoreAppointmentTypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointmentTypesRequest $request)
    {
        if (! Gate::allows('appointment_type_create')) {
            return abort(401);
        }
        $appointment_type = AppointmentType::create($request->all());

        return redirect()->route('admin.appointment_types.index');
    }


    /**
     * Show the form for editing AppointmentType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('appointment_type_edit')) {
            return abort(401);
        }
        $appointment_type = AppointmentType::findOrFail($id);

        return view('admin.appointment_types.edit', compact('appointment_type'));
    }

    /**
     * Update AppointmentType in storage.
     *
     * @param  \App\Http\Requests\UpdateAppointmentTypesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentTypesRequest $request, $id)
    {
        if (! Gate::allows('appointment_type_edit')) {
            return abort(401);
        }
        $appointment_type = AppointmentType::findOrFail($id);
        $appointment_type->update($request->all());

        return redirect()->route('admin.appointment_types.index');
    }


    /**
     * Display AppointmentType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('appointment_type_view')) {
            return abort(401);
        }
        $appointment_type = AppointmentType::findOrFail($id);

        return view('admin.appointment_types.show', compact('appointment_type'));
    }


    /**
     * Remove AppointmentType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('appointment_type_delete')) {
            return abort(401);
        }
        $appointment_type = AppointmentType::findOrFail($id);
        $appointment_type->delete();

        return redirect()->route('admin.appointment_types.index');
    }

    /**
     * Delete all selected AppointmentType at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('appointment_type_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = AppointmentType::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore AppointmentType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('appointment_type_delete')) {
            return abort(401);
        }
        $appointment_type = AppointmentType::onlyTrashed()->findOrFail($id);
        $appointment_type->restore();

        return redirect()->route('admin.appointment_types.index');
    }

    /**
     * Permanently delete AppointmentType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('appointment_type_delete')) {
            return abort(401);
        }
        $appointment_type = AppointmentType::onlyTrashed()->findOrFail($id);
        $appointment_type->forceDelete();

        return redirect()->route('admin.appointment_types.index');
    }
}
