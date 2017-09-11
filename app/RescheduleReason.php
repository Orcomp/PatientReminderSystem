<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class RescheduleReason
 *
 * @package App
 * @property string $name
*/
class RescheduleReason extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        RescheduleReason::observe(new \App\Observers\UserActionsObserver);
    }
    
}
