<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class City
 *
 * @package App
 * @property string $name
 * @property string $country
*/
class City extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'country_id'];
    
    public static function boot()
    {
        parent::boot();

        City::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCountryIdAttribute($input)
    {
        $this->attributes['country_id'] = $input ? $input : null;
    }
    
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->withTrashed();
    }
    
}
