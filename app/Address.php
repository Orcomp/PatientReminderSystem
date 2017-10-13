<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Address
 *
 * @package App
 * @property string $contact
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $country
 * @property text $note
 * @property string $address_type
*/
class Address extends Model
{
    use SoftDeletes;

    protected $fillable = ['street', 'note', 'contact_id', 'patient_id', 'city_id', 'state_id', 'country_id', 'address_type_id'];

    public static function boot()
    {
        parent::boot();

        Address::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setContactIdAttribute($input)
    {
        $this->attributes['contact_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCityIdAttribute($input)
    {
        $this->attributes['city_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setStateIdAttribute($input)
    {
        $this->attributes['state_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCountryIdAttribute($input)
    {
        $this->attributes['country_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setAddressTypeIdAttribute($input)
    {
        $this->attributes['address_type_id'] = $input ? $input : null;
    }

    public function getContactFullNameAttribute()
    {
        if ($this->contact)
            return $this->contact->full_name;

        if ($this->patient)
            return $this->patient->full_name;

        return null;
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id')->withTrashed();
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->withTrashed();
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withTrashed();
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id')->withTrashed();
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id')->withTrashed();
    }

    public function address_type()
    {
        return $this->belongsTo(AddressType::class, 'address_type_id')->withTrashed();
    }

}
