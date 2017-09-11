<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 *
 * @package App
 * @property string $name
*/
class Country extends Model
{
    use SoftDeletes;

    protected $fillable = ['name'];

    public static function boot()
    {
        parent::boot();

        Country::observe(new \App\Observers\UserActionsObserver);
    }

    public function states() {
        return $this->hasMany('App\State');
    }

    public function cities() {
        return $this->hasMany('App\City');
    }
}
