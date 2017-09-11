<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TreatmentStage
 *
 * @package App
 * @property string $name
*/
class TreatmentStage extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        TreatmentStage::observe(new \App\Observers\UserActionsObserver);
    }
    
}
