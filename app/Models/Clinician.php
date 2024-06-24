<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Clinician extends Model
{
    use HasFactory;

    /**
     * Function to add scope in forms table.
     * @param query Assesment SQL Query.
     * 
     * @return SQL Query.
     */
    public static function scopeAssigned($query) {
        if(Auth::user()->user_type == '4') {
            $patient = Patient::where('user_id', Auth::user()->id)->first();

            $query = $query->leftJoin('clinician_patients as a', 'a.clinician_id', '=', 'clinicians.id')
                ->where('a.patient_id', $patient->id)
                ->select('clinicians.*');
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinicianPatients()
    {
        return $this->hasMany(ClinicianPatient::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'clinician_patients', 'clinician_id', 'patient_id');
    }

}

