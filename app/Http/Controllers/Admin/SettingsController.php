<?php

namespace App\Http\Controllers\Admin;

use App\Settings;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class SettingsController extends Controller
{

    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('settings_access')) {
            return abort(401);
        }

        $settings = Settings::all();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (! Gate::allows('settings_edit')) {
            return abort(401);
        }

        $setting = Settings::findOrFail($id);

        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSettingsRequest $request, $id)
    {
        if (! Gate::allows('settings_edit')) {
            return abort(401);
        }

        $setting = Settings::findOrFail($id);
        $setting->update($request->all());

        return redirect()->route('admin.settings.index');
    }
}
