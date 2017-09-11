<?php

namespace App\Http\Controllers\Admin;

use App\TreatmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTreatmentTypesRequest;
use App\Http\Requests\Admin\UpdateTreatmentTypesRequest;

class TreatmentTypesController extends Controller
{
    /**
     * Display a listing of TreatmentType.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('treatment_type_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('treatment_type_delete')) {
                return abort(401);
            }
            $treatment_types = TreatmentType::onlyTrashed()->get();
        } else {
            $treatment_types = TreatmentType::all();
        }

        return view('admin.treatment_types.index', compact('treatment_types'));
    }

    /**
     * Show the form for creating new TreatmentType.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('treatment_type_create')) {
            return abort(401);
        }
        return view('admin.treatment_types.create');
    }

    /**
     * Store a newly created TreatmentType in storage.
     *
     * @param  \App\Http\Requests\StoreTreatmentTypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTreatmentTypesRequest $request)
    {
        if (! Gate::allows('treatment_type_create')) {
            return abort(401);
        }
        $treatment_type = TreatmentType::create($request->all());



        return redirect()->route('admin.treatment_types.index');
    }


    /**
     * Show the form for editing TreatmentType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('treatment_type_edit')) {
            return abort(401);
        }
        $treatment_type = TreatmentType::findOrFail($id);

        return view('admin.treatment_types.edit', compact('treatment_type'));
    }

    /**
     * Update TreatmentType in storage.
     *
     * @param  \App\Http\Requests\UpdateTreatmentTypesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTreatmentTypesRequest $request, $id)
    {
        if (! Gate::allows('treatment_type_edit')) {
            return abort(401);
        }
        $treatment_type = TreatmentType::findOrFail($id);
        $treatment_type->update($request->all());



        return redirect()->route('admin.treatment_types.index');
    }


    /**
     * Display TreatmentType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('treatment_type_view')) {
            return abort(401);
        }
        $treatments = \App\Treatment::where('treatment_type_id', $id)->get();

        $treatment_type = TreatmentType::findOrFail($id);

        return view('admin.treatment_types.show', compact('treatment_type', 'treatments'));
    }


    /**
     * Remove TreatmentType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('treatment_type_delete')) {
            return abort(401);
        }
        $treatment_type = TreatmentType::findOrFail($id);
        $treatment_type->delete();

        return redirect()->route('admin.treatment_types.index');
    }

    /**
     * Delete all selected TreatmentType at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('treatment_type_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = TreatmentType::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore TreatmentType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('treatment_type_delete')) {
            return abort(401);
        }
        $treatment_type = TreatmentType::onlyTrashed()->findOrFail($id);
        $treatment_type->restore();

        return redirect()->route('admin.treatment_types.index');
    }

    /**
     * Permanently delete TreatmentType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('treatment_type_delete')) {
            return abort(401);
        }
        $treatment_type = TreatmentType::onlyTrashed()->findOrFail($id);
        $treatment_type->forceDelete();

        return redirect()->route('admin.treatment_types.index');
    }
}
