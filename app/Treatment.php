<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Treatment
 *
 * @package App
 * @property string $patient
 * @property string $treatment_type
 * @property string $treatment_stage
 * @property string $start_date
 * @property string $end_date
 * @property text $notes
*/
class Treatment extends Model
{
    use SoftDeletes;

    protected $fillable = ['start_date', 'end_date', 'notes', 'patient_id', 'treatment_type_id', 'treatment_stage_id'];

    public static function boot()
    {
        parent::boot();

        Treatment::observe(new \App\Observers\UserActionsObserver);
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
    public function setTreatmentTypeIdAttribute($input)
    {
        $this->attributes['treatment_type_id'] = $input ? $input : null;
    }

    /**
     * Set to null if empty
     * @param $input
     */
    public function setTreatmentStageIdAttribute($input)
    {
        $this->attributes['treatment_stage_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setStartDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['start_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['start_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getStartDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setEndDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['end_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['end_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getEndDateAttribute($input)
    {
        $zeroDate = str_replace(['Y', 'm', 'd'], ['0000', '00', '00'], config('app.date_format'));

        if ($input != $zeroDate && $input != null) {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('app.date_format'));
        } else {
            return '';
        }
    }

    public function getPatientFullNameAttribute()
    {
        return $this->patient->full_name;
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id')->withTrashed();
    }

    public function treatment_type()
    {
        return $this->belongsTo(TreatmentType::class, 'treatment_type_id')->withTrashed();
    }

    public function treatment_stage()
    {
        return $this->belongsTo(TreatmentStage::class, 'treatment_stage_id')->withTrashed();
    }

    public function scopeOfPatient($query)
    {
        if (\request('patient_id')) {
            return $query->where('treatments.patient_id', \request('patient_id'));
        }
        return $query;
    }

}
