<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ContactType
 *
 * @package App
 * @property string $name
*/
class ContactType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];
    
    public static function boot()
    {
        parent::boot();

        ContactType::observe(new \App\Observers\UserActionsObserver);
    }
    
}
