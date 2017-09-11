<?php

namespace App\Http\Controllers\Admin;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAddressesRequest;
use App\Http\Requests\Admin\UpdateAddressesRequest;

class AddressesController extends Controller
{
    /**
     * Display a listing of Address.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('address_access')) {
            return abort(401);
        }

        if (request('show_deleted') == 1) {
            if (! Gate::allows('address_delete')) {
                return abort(401);
            }
            $addresses = Address::onlyTrashed()->get();
        } else {
            $addresses = Address::all();
        }

        return view('admin.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating new Address.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('address_create')) {
            return abort(401);
        }
        
        $contacts = \App\Contact::get()->pluck('first_name', 'id')->prepend(trans('global.app_please_select'), '');
        $cities = \App\City::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $states = \App\State::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $countries = \App\Country::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $address_types = \App\AddressType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        return view('admin.addresses.create', compact('contacts', 'cities', 'states', 'countries', 'address_types'));
    }

    /**
     * Store a newly created Address in storage.
     *
     * @param  \App\Http\Requests\StoreAddressesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressesRequest $request)
    {
        if (! Gate::allows('address_create')) {
            return abort(401);
        }
        $address = Address::create($request->all());



        return redirect()->route('admin.addresses.index');
    }


    /**
     * Show the form for editing Address.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('address_edit')) {
            return abort(401);
        }
        
        $contacts = \App\Contact::get()->pluck('first_name', 'id')->prepend(trans('global.app_please_select'), '');
        $cities = \App\City::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $states = \App\State::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $countries = \App\Country::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');
        $address_types = \App\AddressType::get()->pluck('name', 'id')->prepend(trans('global.app_please_select'), '');

        $address = Address::findOrFail($id);

        return view('admin.addresses.edit', compact('address', 'contacts', 'cities', 'states', 'countries', 'address_types'));
    }

    /**
     * Update Address in storage.
     *
     * @param  \App\Http\Requests\UpdateAddressesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressesRequest $request, $id)
    {
        if (! Gate::allows('address_edit')) {
            return abort(401);
        }
        $address = Address::findOrFail($id);
        $address->update($request->all());



        return redirect()->route('admin.addresses.index');
    }


    /**
     * Display Address.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('address_view')) {
            return abort(401);
        }
        $address = Address::findOrFail($id);

        return view('admin.addresses.show', compact('address'));
    }


    /**
     * Remove Address from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('address_delete')) {
            return abort(401);
        }
        $address = Address::findOrFail($id);
        $address->delete();

        return redirect()->route('admin.addresses.index');
    }

    /**
     * Delete all selected Address at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('address_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Address::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore Address from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('address_delete')) {
            return abort(401);
        }
        $address = Address::onlyTrashed()->findOrFail($id);
        $address->restore();

        return redirect()->route('admin.addresses.index');
    }

    /**
     * Permanently delete Address from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('address_delete')) {
            return abort(401);
        }
        $address = Address::onlyTrashed()->findOrFail($id);
        $address->forceDelete();

        return redirect()->route('admin.addresses.index');
    }
}
