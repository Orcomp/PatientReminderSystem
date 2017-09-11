<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DesignationType
 *
 * @package App
 * @property string $name
*/
class DesignationType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        DesignationType::observe(new \App\Observers\UserActionsObserver);
    }
    
}
