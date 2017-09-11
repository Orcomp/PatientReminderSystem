<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AppointmentType
 *
 * @package App
 * @property string $name
 */
class AppointmentType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public static function boot()
    {
        parent::boot();

        AppointmentType::observe(new \App\Observers\UserActionsObserver);
    }

}
