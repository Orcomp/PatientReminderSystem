<?php

namespace App\Http\Controllers\Admin;

use App\DiagnosesType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDiagnosesTypesRequest;
use App\Http\Requests\Admin\UpdateDiagnosesTypesRequest;

class DiagnosesTypesController extends Controller
{
    /**
     * Display a listing of DiagnosesType.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('diagnoses_type_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('diagnoses_type_delete')) {
                return abort(401);
            }
            $diagnoses_types = DiagnosesType::onlyTrashed()->get();
        } else {
            $diagnoses_types = DiagnosesType::all();
        }

        return view('admin.diagnoses_types.index', compact('diagnoses_types'));
    }

    /**
     * Show the form for creating new DiagnosesType.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('diagnoses_type_create')) {
            return abort(401);
        }
        return view('admin.diagnoses_types.create');
    }

    /**
     * Store a newly created DiagnosesType in storage.
     *
     * @param  \App\Http\Requests\StoreDiagnosesTypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiagnosesTypesRequest $request)
    {
        if (! Gate::allows('diagnoses_type_create')) {
            return abort(401);
        }
        $diagnoses_type = DiagnosesType::create($request->all());



        return redirect()->route('admin.diagnoses_types.index');
    }


    /**
     * Show the form for editing DiagnosesType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('diagnoses_type_edit')) {
            return abort(401);
        }
        $diagnoses_type = DiagnosesType::findOrFail($id);

        return view('admin.diagnoses_types.edit', compact('diagnoses_type'));
    }

    /**
     * Update DiagnosesType in storage.
     *
     * @param  \App\Http\Requests\UpdateDiagnosesTypesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiagnosesTypesRequest $request, $id)
    {
        if (! Gate::allows('diagnoses_type_edit')) {
            return abort(401);
        }
        $diagnoses_type = DiagnosesType::findOrFail($id);
        $diagnoses_type->update($request->all());



        return redirect()->route('admin.diagnoses_types.index');
    }


    /**
     * Display DiagnosesType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('diagnoses_type_view')) {
            return abort(401);
        }
        $diagnoses = \App\Diagnosis::where('diagnose_type_id', $id)->get();

        $diagnoses_type = DiagnosesType::findOrFail($id);

        return view('admin.diagnoses_types.show', compact('diagnoses_type', 'diagnoses'));
    }


    /**
     * Remove DiagnosesType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('diagnoses_type_delete')) {
            return abort(401);
        }
        $diagnoses_type = DiagnosesType::findOrFail($id);
        $diagnoses_type->delete();

        return redirect()->route('admin.diagnoses_types.index');
    }

    /**
     * Delete all selected DiagnosesType at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('diagnoses_type_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = DiagnosesType::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore DiagnosesType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('diagnoses_type_delete')) {
            return abort(401);
        }
        $diagnoses_type = DiagnosesType::onlyTrashed()->findOrFail($id);
        $diagnoses_type->restore();

        return redirect()->route('admin.diagnoses_types.index');
    }

    /**
     * Permanently delete DiagnosesType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('diagnoses_type_delete')) {
            return abort(401);
        }
        $diagnoses_type = DiagnosesType::onlyTrashed()->findOrFail($id);
        $diagnoses_type->forceDelete();

        return redirect()->route('admin.diagnoses_types.index');
    }
}
