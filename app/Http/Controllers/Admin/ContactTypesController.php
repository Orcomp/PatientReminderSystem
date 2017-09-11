<?php

namespace App\Http\Controllers\Admin;

use App\ContactType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContactTypesRequest;
use App\Http\Requests\Admin\UpdateContactTypesRequest;

class ContactTypesController extends Controller
{
    /**
     * Display a listing of ContactType.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('contact_type_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('contact_type_delete')) {
                return abort(401);
            }
            $contact_types = ContactType::onlyTrashed()->get();
        } else {
            $contact_types = ContactType::all();
        }

        return view('admin.contact_types.index', compact('contact_types'));
    }

    /**
     * Show the form for creating new ContactType.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('contact_type_create')) {
            return abort(401);
        }
        return view('admin.contact_types.create');
    }

    /**
     * Store a newly created ContactType in storage.
     *
     * @param  \App\Http\Requests\StoreContactTypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactTypesRequest $request)
    {
        if (! Gate::allows('contact_type_create')) {
            return abort(401);
        }
        $contact_type = ContactType::create($request->all());



        return redirect()->route('admin.contact_types.index');
    }


    /**
     * Show the form for editing ContactType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('contact_type_edit')) {
            return abort(401);
        }
        $contact_type = ContactType::findOrFail($id);

        return view('admin.contact_types.edit', compact('contact_type'));
    }

    /**
     * Update ContactType in storage.
     *
     * @param  \App\Http\Requests\UpdateContactTypesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactTypesRequest $request, $id)
    {
        if (! Gate::allows('contact_type_edit')) {
            return abort(401);
        }
        $contact_type = ContactType::findOrFail($id);
        $contact_type->update($request->all());



        return redirect()->route('admin.contact_types.index');
    }


    /**
     * Display ContactType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('contact_type_view')) {
            return abort(401);
        }
        $contacts = \App\Contact::where('contact_type_id', $id)->get();

        $contact_type = ContactType::findOrFail($id);

        return view('admin.contact_types.show', compact('contact_type', 'contacts'));
    }


    /**
     * Remove ContactType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('contact_type_delete')) {
            return abort(401);
        }
        $contact_type = ContactType::findOrFail($id);
        $contact_type->delete();

        return redirect()->route('admin.contact_types.index');
    }

    /**
     * Delete all selected ContactType at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('contact_type_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = ContactType::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore ContactType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('contact_type_delete')) {
            return abort(401);
        }
        $contact_type = ContactType::onlyTrashed()->findOrFail($id);
        $contact_type->restore();

        return redirect()->route('admin.contact_types.index');
    }

    /**
     * Permanently delete ContactType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('contact_type_delete')) {
            return abort(401);
        }
        $contact_type = ContactType::onlyTrashed()->findOrFail($id);
        $contact_type->forceDelete();

        return redirect()->route('admin.contact_types.index');
    }
}
