<?php

namespace App\Http\Controllers\Admin;

use App\Patient;
use App\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTreatmentsRequest;
use App\Http\Requests\Admin\UpdateTreatmentsRequest;

class TreatmentsController extends Controller
{
    /**
     * Display a listing of Treatment.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! Gate::allows('treatment_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('treatment_delete')) {
                return abort(401);
            }
            $treatments = Treatment::ofPatient()->onlyTrashed()->get();
        } else {
            $treatments = Treatment::ofPatient()->get();
        }

        $patient = Patient::find($request->input('patient_id'));

        return view('admin.treatments.index', compact('treatments', 'patient'));
    }

    /**
     * Show the form for creating new Treatment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (! Gate::allows('treatment_create')) {
            return abort(401);
        }

        $patients = \App\Patient::get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');
        $treatment_types = \App\TreatmentType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $treatment_stages = \App\TreatmentStage::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $redirect_to = $request['redirect_to'] ?? null;

        return view('admin.treatments.create', compact('patients', 'treatment_types', 'treatment_stages', 'redirect_to'));
    }

    /**
     * Store a newly created Treatment in storage.
     *
     * @param  \App\Http\Requests\StoreTreatmentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTreatmentsRequest $request)
    {
        if (! Gate::allows('treatment_create')) {
            return abort(401);
        }
        $treatment = Treatment::create($request->all());

        if ($request->get('redirect_to')) {
            return redirect($request->get('redirect_to'));
        }

        return redirect()->back();
    }


    /**
     * Show the form for editing Treatment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('treatment_edit')) {
            return abort(401);
        }

        $patients = \App\Patient::get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');
        $treatment_types = \App\TreatmentType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $treatment_stages = \App\TreatmentStage::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        $treatment = Treatment::findOrFail($id);

        return view('admin.treatments.edit', compact('treatment', 'patients', 'treatment_types', 'treatment_stages'));
    }

    /**
     * Update Treatment in storage.
     *
     * @param  \App\Http\Requests\UpdateTreatmentsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTreatmentsRequest $request, $id)
    {
        if (! Gate::allows('treatment_edit')) {
            return abort(401);
        }
        $treatment = Treatment::findOrFail($id);
        $treatment->update($request->all());



        return redirect()->route('admin.treatments.index');
    }


    /**
     * Display Treatment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('treatment_view')) {
            return abort(401);
        }
        $treatment = Treatment::findOrFail($id);

        return view('admin.treatments.show', compact('treatment'));
    }


    /**
     * Remove Treatment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('treatment_delete')) {
            return abort(401);
        }
        $treatment = Treatment::findOrFail($id);
        $treatment->delete();

        return redirect()->route('admin.treatments.index');
    }

    /**
     * Delete all selected Treatment at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('treatment_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Treatment::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Treatment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('treatment_delete')) {
            return abort(401);
        }
        $treatment = Treatment::onlyTrashed()->findOrFail($id);
        $treatment->restore();

        return redirect()->route('admin.treatments.index');
    }

    /**
     * Permanently delete Treatment from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('treatment_delete')) {
            return abort(401);
        }
        $treatment = Treatment::onlyTrashed()->findOrFail($id);
        $treatment->forceDelete();

        return redirect()->route('admin.treatments.index');
    }
}
