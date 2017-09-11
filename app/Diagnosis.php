<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Diagnosis
 *
 * @package App
 * @property string $patient
 * @property string $diagnose_type
 * @property string $diagnose_date
 * @property text $notes
*/
class Diagnosis extends Model
{
    use SoftDeletes;

    protected $fillable = ['diagnose_date', 'notes', 'patient_id', 'diagnose_type_id'];

    public static function boot()
    {
        parent::boot();

        Diagnosis::observe(new \App\Observers\UserActionsObserver);
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
    public function setDiagnoseTypeIdAttribute($input)
    {
        $this->attributes['diagnose_type_id'] = $input ? $input : null;
    }

    /**
     * Set attribute to date format
     * @param $input
     */
    public function setDiagnoseDateAttribute($input)
    {
        if ($input != null && $input != '') {
            $this->attributes['diagnose_date'] = Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
        } else {
            $this->attributes['diagnose_date'] = null;
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getDiagnoseDateAttribute($input)
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

    public function diagnose_type()
    {
        return $this->belongsTo(DiagnosesType::class, 'diagnose_type_id')->withTrashed();
    }

    public function scopeOfPatient($query)
    {
        if (\request('patient_id')) {
            return $query->where('diagnoses.patient_id', \request('patient_id'));
        }
        return $query;
    }

}
