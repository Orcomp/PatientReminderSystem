<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DiagnosesType
 *
 * @package App
 * @property string $name
*/
class DiagnosesType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        DiagnosesType::observe(new \App\Observers\UserActionsObserver);
    }
    
}
