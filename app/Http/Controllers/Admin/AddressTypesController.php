<?php

namespace App\Http\Controllers\Admin;

use App\AddressType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAddressTypesRequest;
use App\Http\Requests\Admin\UpdateAddressTypesRequest;

class AddressTypesController extends Controller
{
    /**
     * Display a listing of AddressType.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('address_type_access')) {
            return abort(401);
        }


        if (request('show_deleted') == 1) {
            if (! Gate::allows('address_type_delete')) {
                return abort(401);
            }
            $address_types = AddressType::onlyTrashed()->get();
        } else {
            $address_types = AddressType::all();
        }

        return view('admin.address_types.index', compact('address_types'));
    }

    /**
     * Show the form for creating new AddressType.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('address_type_create')) {
            return abort(401);
        }
        return view('admin.address_types.create');
    }

    /**
     * Store a newly created AddressType in storage.
     *
     * @param  \App\Http\Requests\StoreAddressTypesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressTypesRequest $request)
    {
        if (! Gate::allows('address_type_create')) {
            return abort(401);
        }
        $address_type = AddressType::create($request->all());



        return redirect()->route('admin.address_types.index');
    }


    /**
     * Show the form for editing AddressType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('address_type_edit')) {
            return abort(401);
        }
        $address_type = AddressType::findOrFail($id);

        return view('admin.address_types.edit', compact('address_type'));
    }

    /**
     * Update AddressType in storage.
     *
     * @param  \App\Http\Requests\UpdateAddressTypesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressTypesRequest $request, $id)
    {
        if (! Gate::allows('address_type_edit')) {
            return abort(401);
        }
        $address_type = AddressType::findOrFail($id);
        $address_type->update($request->all());



        return redirect()->route('admin.address_types.index');
    }


    /**
     * Display AddressType.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (! Gate::allows('address_type_view')) {
            return abort(401);
        }
        $addresses = \App\Address::where('address_type_id', $id)->get();

        $address_type = AddressType::findOrFail($id);

        return view('admin.address_types.show', compact('address_type', 'addresses'));
    }


    /**
     * Remove AddressType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (! Gate::allows('address_type_delete')) {
            return abort(401);
        }
        $address_type = AddressType::findOrFail($id);
        $address_type->delete();

        return redirect()->route('admin.address_types.index');
    }

    /**
     * Delete all selected AddressType at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('address_type_delete')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = AddressType::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }


    /**
     * Restore AddressType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (! Gate::allows('address_type_delete')) {
            return abort(401);
        }
        $address_type = AddressType::onlyTrashed()->findOrFail($id);
        $address_type->restore();

        return redirect()->route('admin.address_types.index');
    }

    /**
     * Permanently delete AddressType from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function perma_del($id)
    {
        if (! Gate::allows('address_type_delete')) {
            return abort(401);
        }
        $address_type = AddressType::onlyTrashed()->findOrFail($id);
        $address_type->forceDelete();

        return redirect()->route('admin.address_types.index');
    }
}
