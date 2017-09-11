<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Appointment
 *
 * @package App
 * @property string $patient
 * @property string $user
 * @property string $appointment_time
 * @property string $confirmed_at
 * @property string $contacted_contact
 * @property text $notes
 * @property string $created_by
 * @property string $appointment_type
*/
class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = ['appointment_time', 'confirmed_at', 'notes', 'patient_id', 'user_id', 'contacted_contact_id', 'created_by_id', 'appointment_type_id'];

    public static function boot()
    {
        parent::boot();

        Appointment::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setPatientIdAttribute($input)
    {
        $this->attributes['patient_id'] = $input ? $input : null;
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
     * Set attribute to date format
     * @param $input
     */
    public function setAppointmentTimeAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['appointment_time'] = Carbon::createFromFormat(config('app.date_format') . ' H:i', $input)->format('Y-m-d H:i');
        } else {
            $this->attributes['appointment_time'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getAppointmentTimeAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i');
        } else {
            return '';
        }
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setConfirmedAtAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['confirmed_at'] = Carbon::createFromFormat(config('app.date_format') . ' H:i', $input)->format('Y-m-d H:i');
        } else {
            $this->attributes['confirmed_at'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getConfirmedAtAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i');
        } else {
            return '';
        }
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setContactedContactIdAttribute($input)
    {
        $this->attributes['contacted_contact_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCreatedByIdAttribute($input)
    {
        $this->attributes['created_by_id'] = $input ? $input : null;
    }

    public function setSendTypeAttribute($input)
    {
        $this->attributes['send_type'] = $input ? $input : null;
    }

    public function getPatientFullNameAttribute()
    {
        return $this->patient->full_name;
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contacted_contact()
    {
        return $this->belongsTo(Contact::class, 'contacted_contact_id')->withTrashed();
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function scopeOfPatient($query)
    {
        if (\request('patient_id')) {
            return $query->where('appointments.patient_id', \request('patient_id'));
        }
        return $query;
    }

    public function appointment_type()
    {
        return $this->belongsTo(AppointmentType::class, 'appointment_type_id');
    }

}
