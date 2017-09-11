<?php

namespace App\Http\Controllers\Admin;

use App\Diagnosis;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDiagnosesRequest;
use App\Http\Requests\Admin\UpdateDiagnosesRequest;

class DiagnosesController extends Controller
{
    /**
     * Display a listing of Diagnosis.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! Gate::allows('diagnosis_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('diagnosis_delete')) {
                return abort(401);
            }
            $diagnoses = Diagnosis::ofPatient()->onlyTrashed()->get();
        } else {
            $diagnoses = Diagnosis::ofPatient()->get();
        }

        $patient = Patient::find($request->input('patient_id'));

        return view('admin.diagnoses.index', compact('diagnoses', 'patient'));
    }

    /**
     * Show the form for creating new Diagnosis.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (! Gate::allows('diagnosis_create')) {
            return abort(401);
        }

        $patients = \App\Patient::get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');
        $diagnose_types = \App\DiagnosesType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $redirect_to = $request['redirect_to'] ?? null;

        return view('admin.diagnoses.create', compact('patients', 'diagnose_types', 'redirect_to'));
    }

    /**
     * Store a newly created Diagnosis in storage.
     *
     * @param  \App\Http\Requests\StoreDiagnosesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiagnosesRequest $request)
    {
        if (! Gate::allows('diagnosis_create')) {
            return abort(401);
        }

        $diagnosis = Diagnosis::create($request->all());

        if ($request->get('redirect_to')) {
            return redirect($request->get('redirect_to'));
        }

        return redirect()->route('admin.diagnoses.index');
    }


    /**
     * Show the form for editing Diagnosis.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('diagnosis_edit')) {
            return abort(401);
        }

        $patients = \App\Patient::get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');
        $diagnose_types = \App\DiagnosesType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        $diagnosis = Diagnosis::findOrFail($id);

        return view('admin.diagnoses.edit', compact('diagnosis', 'patients', 'diagnose_types'));
    }

    /**
     * Update Diagnosis in storage.
     *
     * @param  \App\Http\Requests\UpdateDiagnosesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiagnosesRequest $request, $id)
    {
        if (! Gate::allows('diagnosis_edit')) {
            return abort(401);
        }
        $diagnosis = Diagnosis::findOrFail($id);
        $diagnosis->update($request->all());



        return redirect()->route('admin.diagnoses.index');
    }


    /**
     * Display Diagnosis.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('diagnosis_view')) {
            return abort(401);
        }
        $diagnosis = Diagnosis::findOrFail($id);

        return view('admin.diagnoses.show', compact('diagnosis'));
    }


    /**
     * Remove Diagnosis from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('diagnosis_delete')) {
            return abort(401);
        }
        $diagnosis = Diagnosis::findOrFail($id);
        $diagnosis->delete();

        return redirect()->route('admin.diagnoses.index');
    }

    /**
     * Delete all selected Diagnosis at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('diagnosis_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Diagnosis::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Diagnosis from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('diagnosis_delete')) {
            return abort(401);
        }
        $diagnosis = Diagnosis::onlyTrashed()->findOrFail($id);
        $diagnosis->restore();

        return redirect()->route('admin.diagnoses.index');
    }

    /**
     * Permanently delete Diagnosis from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('diagnosis_delete')) {
            return abort(401);
        }
        $diagnosis = Diagnosis::onlyTrashed()->findOrFail($id);
        $diagnosis->forceDelete();

        return redirect()->route('admin.diagnoses.index');
    }
}
