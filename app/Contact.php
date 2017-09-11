<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

/**
 * Class Contact
 *
 * @package App
 * @property string $first_name
 * @property string $last_name
 * @property string $mobile_number
 * @property string $phone_number
 * @property string $email
 * @property string $contact_type
 * @property string $designation_type
 * @property string $user
 * @property tinyInteger $is_primary
 * @property string $patient
*/
class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'mobile_number', 'phone_number', 'email', 'is_primary',
        'contact_type_id', 'designation_type_id', 'user_id', 'patient_id'];
    protected $appends = ['full_name'];

    public static function boot()
    {
        parent::boot();

        Contact::observe(new \App\Observers\UserActionsObserver);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setContactTypeIdAttribute($input)
    {
        $this->attributes['contact_type_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setDesignationTypeIdAttribute($input)
    {
        $this->attributes['designation_type_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setUserIdAttribute($input)
    {
        $this->attributes['user_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setPatientIdAttribute($input)
    {
        $this->attributes['patient_id'] = $input ? $input : null;
    }

    public function contact_type()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id')->withTrashed();
    }

    public function designation_type()
    {
        return $this->belongsTo(DesignationType::class, 'designation_type_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->withTrashed();
    }

    public function addresses()
    {
        return $this->hasMany('App\Address');
    }

    public function scopeOfPatient($query)
    {
        if (\request('patient_id')) {
            return $query->where('contacts.patient_id', \request('patient_id'));
        }
        return $query;
    }

}
