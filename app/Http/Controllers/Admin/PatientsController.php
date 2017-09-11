<?php

namespace App\Http\Controllers\Admin;

use App\Patient;
use App\Contact;
use App\Country;
use App\State;
use App\City;
use App\Address;
use App\AddressType;
use App\ContactType;
use App\DesignationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePatientsRequest;
use App\Http\Requests\Admin\UpdatePatientsRequest;

class PatientsController extends Controller
{
    /**
     * Display a listing of Patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('patient_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('patient_delete')) {
                return abort(401);
            }
            $patients = Patient::onlyTrashed()->get();
        } else {
            $patients = Patient::all();
        }

        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating new Patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('patient_create')) {
            return abort(401);
        }
        $enum_gender = Patient::$enum_gender;
        $contact_types = ContactType::where('name', '!=', 'Patient')->pluck('name', 'id');
        $designation_types = DesignationType::pluck('name', 'id');
        $address_types = AddressType::pluck('name', 'id');
        $countries = Country::all();

        return view('admin.patients.create', compact('enum_gender', 'contact_types', 'designation_types', 'address_types', 'countries'));
    }

    /**
     * Store a newly created Patient in storage.
     *
     * @param  \App\Http\Requests\StorePatientsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatientsRequest $request)
    {
        if (! Gate::allows('patient_create')) {
            return abort(401);
        }

        // dd($request['contact']);

        $patient = Patient::create($request->all());

        if ($request->get('contact')) {
            $contacts = $request->get('contact');
            foreach ($contacts as $contact) {
                $new_contact = Contact::create([
                    'first_name'          => $contact['first_name'],
                    'last_name'           => $contact['last_name'],
                    'mobile_number'       => $contact['mobile_number'],
                    'phone_number'        => $contact['phone_number'],
                    'email'               => $contact['email'],
                    'contact_type_id'     => $contact['contact_type_id'],
                    'designation_type_id' => $contact['designation_type_id'],
                    'is_primary'          => $contact['is_primary'],
                    'user_id'             => null,
                    'patient_id'          => $patient->id,
                ]);
                if ($contact['address']) {
                    $addresses = $contact['address'];
                    foreach ($addresses as $address) {
                        if (isset($address['city'])) {
                            $city = City::create([
                                'name'       => $address['city'],
                                'country_id' => $address['country_id'],
                            ])->id;
                        } else {
                            $city = isset($address['city_id']) ? $address['city_id'] : null;
                        }
                        if (isset($address['state'])) {
                            $state = State::create([
                                'name' => $address['state'],
                                'country_id' => $address['country_id'],
                            ])->id;
                        } else {
                            $state = isset($address['state_id']) ? $address['state_id'] : null;
                        }
                        Address::create([
                            'contact_id'      => $new_contact->id,
                            'street'          => $address['street'],
                            'city_id'         => $city,
                            'state_id'        => $state,
                            'country_id'      => isset($address['country_id']) ? $address['country_id'] : null,
                            'note'            => $address['note'],
                            'address_type_id' => $address['address_type_id'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.patients.index');
    }


    /**
     * Show the form for editing Patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('patient_edit')) {
            return abort(401);
        }

        $enum_gender = Patient::$enum_gender;
        $patient = Patient::findOrFail($id);
        $contacts = Contact::where('patient_id', $patient->id)->get();
        $contact_types = ContactType::where('name', '!=', 'Patient')->pluck('name', 'id');
        $address_types = AddressType::pluck('name', 'id');
        $countries = Country::all();
        $states = State::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $designation_types = DesignationType::pluck('name', 'id');

        return view('admin.patients.edit', compact(
            'patient',
            'enum_gender',
            'contacts',
            'contact_types',
            'designation_types',
            'address_types',
            'countries',
            'states',
            'cities'
        ));
    }

    /**
     * Update Patient in storage.
     *
     * @param  \App\Http\Requests\UpdatePatientsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePatientsRequest $request, $id)
    {
        if (! Gate::allows('patient_edit')) {
            return abort(401);
        }

        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        if ($request->get('contact')) {
            $contacts = $request->get('contact');
            foreach ($contacts as $contact) {
                $existing_contact = Contact::findOrFail($contact['id']);
                $existing_contact->update([
                    'first_name'          => $contact['first_name'],
                    'last_name'           => $contact['last_name'],
                    'mobile_number'       => $contact['mobile_number'],
                    'phone_number'        => $contact['phone_number'],
                    'email'               => $contact['email'],
                    'contact_type_id'     => $contact['contact_type_id'],
                    'designation_type_id' => $contact['designation_type_id'],
                    'is_primary'          => $contact['is_primary'],
                ]);
                if (isset($contact['address'])) {
                    $addresses = $contact['address'];
                    foreach ($addresses as $address) {
                        if (isset($address['city'])) {
                            $city = City::create([
                                'name'       => $address['city'],
                                'country_id' => $address['country_id'],
                            ])->id;
                        } else {
                            $city = isset($address['city_id']) ? $address['city_id'] : null;
                        }
                        if (isset($address['state'])) {
                            $state = State::create([
                                'name' => $address['state'],
                                'country_id' => $address['country_id'],
                            ])->id;
                        } else {
                            $state = isset($address['state_id']) ? $address['state_id'] : null;
                        }
                        $existing_address = Address::findOrFail($address['id']);
                        $existing_address->update([
                            'contact_id'      => $existing_contact->id,
                            'street'          => $address['street'],
                            'city_id'         => $city,
                            'state_id'        => $state,
                            'country_id'      => isset($address['country_id']) ? $address['country_id'] : null,
                            'note'            => $address['note'],
                            'address_type_id' => $address['address_type_id'],
                        ]);
                    }
                }

                // new address for existing contact
                if (isset($contact['new_address'])) {
                    $new_addresses = $contact['new_address'];
                    foreach ($new_addresses as $address) {
                        if (isset($address['city'])) {
                            $city = City::create([
                                'name'       => $address['city'],
                                'country_id' => $address['country_id'],
                            ])->id;
                        } else {
                            $city = isset($address['city_id']) ? $address['city_id'] : null;
                        }
                        if (isset($address['state'])) {
                            $state = State::create([
                                'name' => $address['state'],
                                'country_id' => $address['country_id'],
                            ])->id;
                        } else {
                            $state = isset($address['state_id']) ? $address['state_id'] : null;
                        }
                        Address::create([
                            'contact_id'      => $existing_contact->id,
                            'street'          => $address['street'],
                            'city_id'         => $city,
                            'state_id'        => $state,
                            'country_id'      => isset($address['country_id']) ? $address['country_id'] : null,
                            'note'            => $address['note'],
                            'address_type_id' => $address['address_type_id'],
                        ]);
                    }
                }
            }
        }

        if ($request->get('new_contact')) {
            $contacts = $request->get('new_contact');
            foreach ($contacts as $contact) {
                $new_contact = Contact::create([
                    'first_name'          => $contact['first_name'],
                    'last_name'           => $contact['last_name'],
                    'mobile_number'       => $contact['mobile_number'],
                    'phone_number'        => $contact['phone_number'],
                    'email'               => $contact['email'],
                    'contact_type_id'     => $contact['contact_type_id'],
                    'designation_type_id' => $contact['designation_type_id'],
                    'is_primary'          => $contact['is_primary'],
                    'user_id'             => null,
                    'patient_id'          => $patient->id,
                ]);

                // new address for new contact
                if (isset($contact['address'])) {
                    $new_addresses = $contact['address'];
                    foreach ($new_addresses as $address) {
                        if (isset($address['city'])) {
                            $city = City::create([
                                'name'       => $address['city'],
                                'country_id' => $address['country_id'],
                            ])->id;
                        } else {
                            $city = isset($address['city_id']) ? $address['city_id'] : null;
                        }
                        if (isset($address['state'])) {
                            $state = State::create([
                                'name' => $address['state'],
                                'country_id' => $address['country_id'],
                            ])->id;
                        } else {
                            $state = isset($address['state_id']) ? $address['state_id'] : null;
                        }
                        Address::create([
                            'contact_id'      => $new_contact->id,
                            'street'          => $address['street'],
                            'city_id'         => $city,
                            'state_id'        => $state,
                            'country_id'      => isset($address['country_id']) ? $address['country_id'] : null,
                            'note'            => $address['note'],
                            'address_type_id' => $address['address_type_id'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.patients.index');
    }


    /**
     * Display Patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('patient_view')) {
            return abort(401);
        }
        $diagnoses = \App\Diagnosis::where('patient_id', $id)->orderBy('id', 'desc')->get();
        $treatments = \App\Treatment::where('patient_id', $id)->orderBy('id', 'desc')->get();
        $appointments = \App\Appointment::where('patient_id', $id)->orderBy('id', 'desc')->get();
        $contacts = \App\Contact::where('patient_id', $id)->orderBy('id', 'desc')->get();

        $patient = Patient::findOrFail($id);

        return view('admin.patients.show', compact('patient', 'diagnoses', 'treatments', 'appointments', 'contacts'));
    }


    /**
     * Remove Patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('admin.patients.index');
    }

    /**
     * Delete all selected Patient at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Patient::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $patient->restore();

        return redirect()->route('admin.patients.index');
    }

    /**
     * Permanently delete Patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('patient_delete')) {
            return abort(401);
        }
        $patient = Patient::onlyTrashed()->findOrFail($id);
        $patient->forceDelete();

        return redirect()->route('admin.patients.index');
    }
}
