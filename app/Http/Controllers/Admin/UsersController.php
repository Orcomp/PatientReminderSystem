<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Country;
use App\ContactType;
use App\DesignationType;
use App\AddressType;
use App\Contact;
use App\Address;
use App\State;
use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('user_access')) {
            return abort(401);
        }

        $users = User::all();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id');
        $countries = Country::all();
        $contact_types = ContactType::pluck('name', 'id');
        $designation_types = DesignationType::pluck('name', 'id');
        $address_types = AddressType::pluck('name', 'id');

        return view('admin.users.create', compact(
            'roles',
            'countries',
            'contact_types',
            'designation_types',
            'address_types'
        ));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUsersRequest $request)
    {
        if (! Gate::allows('user_create')) {
            return abort(401);
        }
        $user = User::create($request->all());
        $user->role()->sync(array_filter((array)$request->input('role')));

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
                    'user_id'             => $user->id,
                    'patient_id'          => null
                ]);
                if ($contact['address']) {
                    $addresses = $contact['address'];
                    foreach ($addresses as $address) {
                        Address::create([
                            'contact_id'      => $new_contact->id,
                            'street'          => $address['street'],
                            'city_id'         => isset($address['city_id']) ? $address['city_id'] : null,
                            'state_id'        => isset($address['state_id']) ? $address['state_id'] : null,
                            'country_id'      => isset($address['country_id']) ? $address['country_id'] : null,
                            'note'            => $address['note'],
                            'address_type_id' => $address['address_type_id'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('admin.users.index');
    }


    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id');
        $user = User::findOrFail($id);
        $contacts = Contact::where('user_id', $user->id)->get();
        $contact_types = ContactType::pluck('name', 'id');
        $address_types = AddressType::pluck('name', 'id');
        $countries = Country::all();
        $states = State::pluck('name', 'id');
        $cities = City::pluck('name', 'id');
        $designation_types = DesignationType::pluck('name', 'id');

        return view('admin.users.edit', compact(
            'user',
            'roles',
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
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        if (! Gate::allows('user_edit')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->update($request->all());
        $user->role()->sync(array_filter((array)$request->input('role')));

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
                        $existing_address = Address::findOrFail($address['id']);
                        $existing_address->update([
                            'contact_id'      => $existing_contact->id,
                            'street'          => $address['street'],
                            'city_id'         => isset($address['city_id']) ? $address['city_id'] : null,
                            'state_id'        => isset($address['state_id']) ? $address['state_id'] : null,
                            'country_id'      => isset($address['country_id']) ? $address['country_id'] : null,
                            'note'            => $address['note'],
                            'address_type_id' => $address['address_type_id'],
                        ]);
                    }
                }
                if (isset($contact['new_address'])) {
                    $new_addresses = $contact['new_address'];
                    foreach ($new_addresses as $address) {
                        Address::create([
                            'contact_id'      => $existing_contact->id,
                            'street'          => $address['street'],
                            'city_id'         => isset($address['city_id']) ? $address['city_id'] : null,
                            'state_id'        => isset($address['state_id']) ? $address['state_id'] : null,
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
                    'user_id'             => $user->id,
                    'patient_id'          => null
                ]);
                if (isset($contact['address'])) {
                    $new_addresses = $contact['address'];
                    foreach ($new_addresses as $address) {
                        Address::create([
                            'contact_id'      => $new_contact->id,
                            'street'          => $address['street'],
                            'city_id'         => isset($address['city_id']) ? $address['city_id'] : null,
                            'state_id'        => isset($address['state_id']) ? $address['state_id'] : null,
                            'country_id'      => isset($address['country_id']) ? $address['country_id'] : null,
                            'note'            => $address['note'],
                            'address_type_id' => $address['address_type_id'],
                        ]);
                    }
                }
            }
        }


        return redirect()->route('admin.users.index');
    }


    /**
     * Display User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('user_view')) {
            return abort(401);
        }

        $roles = \App\Role::get()->pluck('title', 'id');
        $user_actions = \App\UserAction::where('user_id', $id)->get();
        $appointments = \App\Appointment::where('user_id', $id)->get();
        $appointment_logs = \App\AppointmentLog::where('created_by_id', $id)->get();
        $appointments = \App\Appointment::where('created_by_id', $id)->get();
        $contacts = \App\Contact::where('user_id', $id)->get();
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user', 'user_actions', 'appointments', 'appointment_logs', 'appointments', 'contacts'));
    }


    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index');
    }

    /**
     * Delete all selected User at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('user_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = User::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
