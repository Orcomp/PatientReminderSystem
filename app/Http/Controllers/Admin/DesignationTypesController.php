<?php

namespace App\Http\Controllers\Admin;

use App\DesignationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDesignationTypesRequest;
use App\Http\Requests\Admin\UpdateDesignationTypesRequest;

class DesignationTypesController extends Controller
{
    /**
     * Display a listing of DesignationType.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('designation_type_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('designation_type_delete')) {
                return abort(401);
            }
            $designation_types = DesignationType::onlyTrashed()->get();
        } else {
            $designation_types = DesignationType::all();
        }

        return view('admin.designation_types.index', compact('designation_types'));
    }

    /**
     * Show the form for creating new DesignationType.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('designation_type_create')) {
            return abort(401);
        }
        return view('admin.designation_types.create');
    }

    /**
     * Store a newly created DesignationType in storage.
     *
     * @param  \App\Http\Requests\StoreDesignationTypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDesignationTypesRequest $request)
    {
        if (! Gate::allows('designation_type_create')) {
            return abort(401);
        }
        $designation_type = DesignationType::create($request->all());



        return redirect()->route('admin.designation_types.index');
    }


    /**
     * Show the form for editing DesignationType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('designation_type_edit')) {
            return abort(401);
        }
        $designation_type = DesignationType::findOrFail($id);

        return view('admin.designation_types.edit', compact('designation_type'));
    }

    /**
     * Update DesignationType in storage.
     *
     * @param  \App\Http\Requests\UpdateDesignationTypesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDesignationTypesRequest $request, $id)
    {
        if (! Gate::allows('designation_type_edit')) {
            return abort(401);
        }
        $designation_type = DesignationType::findOrFail($id);
        $designation_type->update($request->all());



        return redirect()->route('admin.designation_types.index');
    }


    /**
     * Display DesignationType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('designation_type_view')) {
            return abort(401);
        }
        $contacts = \App\Contact::where('designation_type_id', $id)->get();

        $designation_type = DesignationType::findOrFail($id);

        return view('admin.designation_types.show', compact('designation_type', 'contacts'));
    }


    /**
     * Remove DesignationType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('designation_type_delete')) {
            return abort(401);
        }
        $designation_type = DesignationType::findOrFail($id);
        $designation_type->delete();

        return redirect()->route('admin.designation_types.index');
    }

    /**
     * Delete all selected DesignationType at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('designation_type_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = DesignationType::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore DesignationType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('designation_type_delete')) {
            return abort(401);
        }
        $designation_type = DesignationType::onlyTrashed()->findOrFail($id);
        $designation_type->restore();

        return redirect()->route('admin.designation_types.index');
    }

    /**
     * Permanently delete DesignationType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('designation_type_delete')) {
            return abort(401);
        }
        $designation_type = DesignationType::onlyTrashed()->findOrFail($id);
        $designation_type->forceDelete();

        return redirect()->route('admin.designation_types.index');
    }
}
