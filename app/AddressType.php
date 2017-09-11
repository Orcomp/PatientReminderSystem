<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AddressType
 *
 * @package App
 * @property string $name
*/
class AddressType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        AddressType::observe(new \App\Observers\UserActionsObserver);
    }
    
}
