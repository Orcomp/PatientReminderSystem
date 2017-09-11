<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AppointmentLog
 *
 * @package App
 * @property string $appointment
 * @property string $appointment_time
 * @property text $note
 * @property string $reschedule_reason
 * @property string $created_by
*/
class AppointmentLog extends Model
{
    use SoftDeletes;

    protected $fillable = ['appointment_time', 'note', 'appointment_id', 'reschedule_reason_id', 'created_by_id'];

    public static function boot()
    {
        parent::boot();

        AppointmentLog::observe(new \App\Observers\UserActionsObserver);
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setAppointmentIdAttribute($input)
    {
        $this->attributes['appointment_id'] = $input ? $input : null;
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
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format') . ' H:i:s');

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $input)->format(config('app.date_format') . ' H:i:s');
        } else {
            return '';
        }
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setRescheduleReasonIdAttribute($input)
    {
        $this->attributes['reschedule_reason_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setCreatedByIdAttribute($input)
    {
        $this->attributes['created_by_id'] = $input ? $input : null;
    }

    public function getPatientFullNameAttribute()
    {
        return $this->appointment->patient->full_name;
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id')->withTrashed();
    }

    public function reschedule_reason()
    {
        return $this->belongsTo(RescheduleReason::class, 'reschedule_reason_id')->withTrashed();
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

}
