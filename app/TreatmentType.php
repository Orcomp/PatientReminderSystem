<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TreatmentType
 *
 * @package App
 * @property string $name
*/
class TreatmentType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        TreatmentType::observe(new \App\Observers\UserActionsObserver);
    }
    
}
