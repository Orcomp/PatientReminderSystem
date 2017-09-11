<?php

namespace App\Http\Controllers\Admin;

use App\UserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserActionsRequest;
use App\Http\Requests\Admin\UpdateUserActionsRequest;

class UserActionsController extends Controller
{
    /**
     * Display a listing of UserAction.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('user_action_access')) {
            return abort(401);
        }

        $user_actions = UserAction::orderBy('id', 'desc')->get();

        return view('admin.user_actions.index', compact('user_actions'));
    }

    public function show($id)
    {
        if (! Gate::allows('user_action_view')) {
            return abort(401);
        }

        $user_action = UserAction::findOrFail($id);

        return view('admin.user_actions.show', compact('user_action'));
    }
}
