<?php

namespace App\Http\Controllers\Admin;

use App\TreatmentStage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTreatmentStagesRequest;
use App\Http\Requests\Admin\UpdateTreatmentStagesRequest;

class TreatmentStagesController extends Controller
{
    /**
     * Display a listing of TreatmentStage.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('treatment_stage_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('treatment_stage_delete')) {
                return abort(401);
            }
            $treatment_stages = TreatmentStage::onlyTrashed()->get();
        } else {
            $treatment_stages = TreatmentStage::all();
        }

        return view('admin.treatment_stages.index', compact('treatment_stages'));
    }

    /**
     * Show the form for creating new TreatmentStage.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('treatment_stage_create')) {
            return abort(401);
        }
        return view('admin.treatment_stages.create');
    }

    /**
     * Store a newly created TreatmentStage in storage.
     *
     * @param  \App\Http\Requests\StoreTreatmentStagesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTreatmentStagesRequest $request)
    {
        if (! Gate::allows('treatment_stage_create')) {
            return abort(401);
        }
        $treatment_stage = TreatmentStage::create($request->all());



        return redirect()->route('admin.treatment_stages.index');
    }


    /**
     * Show the form for editing TreatmentStage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('treatment_stage_edit')) {
            return abort(401);
        }
        $treatment_stage = TreatmentStage::findOrFail($id);

        return view('admin.treatment_stages.edit', compact('treatment_stage'));
    }

    /**
     * Update TreatmentStage in storage.
     *
     * @param  \App\Http\Requests\UpdateTreatmentStagesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTreatmentStagesRequest $request, $id)
    {
        if (! Gate::allows('treatment_stage_edit')) {
            return abort(401);
        }
        $treatment_stage = TreatmentStage::findOrFail($id);
        $treatment_stage->update($request->all());



        return redirect()->route('admin.treatment_stages.index');
    }


    /**
     * Display TreatmentStage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('treatment_stage_view')) {
            return abort(401);
        }
        $treatments = \App\Treatment::where('treatment_stage_id', $id)->get();

        $treatment_stage = TreatmentStage::findOrFail($id);

        return view('admin.treatment_stages.show', compact('treatment_stage', 'treatments'));
    }


    /**
     * Remove TreatmentStage from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('treatment_stage_delete')) {
            return abort(401);
        }
        $treatment_stage = TreatmentStage::findOrFail($id);
        $treatment_stage->delete();

        return redirect()->route('admin.treatment_stages.index');
    }

    /**
     * Delete all selected TreatmentStage at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('treatment_stage_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = TreatmentStage::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore TreatmentStage from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('treatment_stage_delete')) {
            return abort(401);
        }
        $treatment_stage = TreatmentStage::onlyTrashed()->findOrFail($id);
        $treatment_stage->restore();

        return redirect()->route('admin.treatment_stages.index');
    }

    /**
     * Permanently delete TreatmentStage from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('treatment_stage_delete')) {
            return abort(401);
        }
        $treatment_stage = TreatmentStage::onlyTrashed()->findOrFail($id);
        $treatment_stage->forceDelete();

        return redirect()->route('admin.treatment_stages.index');
    }
}
