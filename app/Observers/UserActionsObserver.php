<?php

namespace App\Observers;

use Auth;
use App\UserAction;

class UserActionsObserver
{

    public function __construct()
    {
        $this->user_actions = config('app.user_actions');
    }

    public function created($model)
    {
        if (Auth::check()) {
            $action_object = $this->user_actions[$model->getTable()];

            UserAction::create([
                'user_id'       => Auth::id(),
                'action'        => 'created',
                'action_object' => trans('global.user-actions.action-objects.' . $model->getTable()) . ': ' . $model->$action_object,
                'new_values'    => json_encode($model->getDirty())
            ]);
        }
    }

    public function updated($model)
    {
        if (Auth::check()) {
            $new_values = $model->getDirty();
            $old_values = [];

            foreach ($new_values as $key => $value) {
                $old_values[$key] = $model->getOriginal($key);
            }

            $action_object = $this->user_actions[$model->getTable()];

            UserAction::create([
                'user_id'       => Auth::id(),
                'action'        => 'updated',
                'action_object' => trans('global.user-actions.action-objects.' . $model->getTable()) . ': ' . $model->$action_object,
                'old_values'    => json_encode($old_values),
                'new_values'    => json_encode($model->getDirty())
            ]);
        }
    }

    public function deleted($model)
    {
        if (Auth::check()) {
            $action_object = $this->user_actions[$model->getTable()];

            UserAction::create([
                'user_id'       => Auth::id(),
                'action'        => 'deleted',
                'action_object' => trans('global.user-actions.action-objects.' . $model->getTable()) . ': ' . $model->$action_object
            ]);
        }
    }
}
