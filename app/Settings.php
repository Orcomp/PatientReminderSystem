<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Settings
 *
 * @package App
 * @property string $title
*/
class Settings extends Model
{
    protected $fillable = ['value'];

    public static function boot()
    {
        parent::boot();

        Settings::observe(new \App\Observers\UserActionsObserver);
    }
}
