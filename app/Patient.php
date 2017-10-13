<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Patient
 *
 * @package App
 * @property string $first_name
 * @property string $last_name
 * @property enum $gender
 * @property string $birth_date
 * @property tinyInteger $schooled
 * @property text $notes
*/
class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'gender', 'birth_date', 'schooled', 'notes'];

    public static function boot()
    {
        parent::boot();

        Patient::observe(new \App\Observers\UserActionsObserver);
    }

    public static $enum_gender = ["Male" => "Male", "Female" => "Female"];

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setBirthDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['birth_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['birth_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getBirthDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function addresses()
    {
        return $this->hasMany('App\Address')->withTrashed();
    }

}
