<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreContactsRequest;
use App\Http\Requests\Admin\UpdateContactsRequest;

class ContactsController extends Controller
{
    /**
     * Display a listing of Contact.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! Gate::allows('contact_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('contact_delete')) {
                return abort(401);
            }
            $contacts = Contact::ofPatient()->onlyTrashed()->get();
        } else {
            $contacts = Contact::ofPatient()->get();
        }

        $patient = Patient::find($request->input('patient_id'));

        return view('admin.contacts.index', compact('contacts', 'patient'));
    }

    /**
     * Show the form for creating new Contact.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (! Gate::allows('contact_create')) {
            return abort(401);
        }

        $contact_types = \App\ContactType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $designation_types = \App\DesignationType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $patients = \App\Patient::get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');
        $redirect_to = $request['redirect_to'] ?? null;

        return view('admin.contacts.create', compact('contact_types', 'designation_types', 'users', 'patients', 'redirect_to'));
    }

    /**
     * Store a newly created Contact in storage.
     *
     * @param  \App\Http\Requests\StoreContactsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactsRequest $request)
    {
        if (! Gate::allows('contact_create')) {
            return abort(401);
        }
        $contact = Contact::create($request->all());

        if ($request->get('redirect_to')) {
            return redirect($request->get('redirect_to'));
        }

        return redirect()->back();
    }


    /**
     * Show the form for editing Contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('contact_edit')) {
            return abort(401);
        }

        $contact_types = \App\ContactType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $designation_types = \App\DesignationType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $patients = \App\Patient::get()->pluck('full_name', 'id')->prepend(trans('global.app_please_select'), '');

        $contact = Contact::findOrFail($id);

        return view('admin.contacts.edit', compact('contact', 'contact_types', 'designation_types', 'users', 'patients'));
    }

    /**
     * Update Contact in storage.
     *
     * @param  \App\Http\Requests\UpdateContactsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactsRequest $request, $id)
    {
        if (! Gate::allows('contact_edit')) {
            return abort(401);
        }
        $contact = Contact::findOrFail($id);
        $contact->update($request->all());



        return redirect()->route('admin.contacts.index');
    }


    /**
     * Display Contact.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('contact_view')) {
            return abort(401);
        }

        $contact_types = \App\ContactType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $designation_types = \App\DesignationType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $users = \App\User::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $patients = \App\Patient::get()->pluck('first_name', 'id')->prepend(trans('global.app_please_select'), '');
        $addresses = \App\Address::where('contact_id', $id)->get();
        $appointments = \App\Appointment::where('contacted_contact_id', $id)->get();

        $contact = Contact::findOrFail($id);

        return view('admin.contacts.show', compact('contact', 'addresses', 'appointments'));
    }


    /**
     * Remove Contact from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('contact_delete')) {
            return abort(401);
        }
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts.index');
    }

    /**
     * Delete all selected Contact at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('contact_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Contact::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Contact from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('contact_delete')) {
            return abort(401);
        }
        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->restore();

        return redirect()->route('admin.contacts.index');
    }

    /**
     * Permanently delete Contact from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('contact_delete')) {
            return abort(401);
        }
        $contact = Contact::onlyTrashed()->findOrFail($id);
        $contact->forceDelete();

        return redirect()->route('admin.contacts.index');
    }
}
