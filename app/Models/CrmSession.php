<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class CrmSession extends Model
{
    use HasFactory;

    /**
     * Function to add scope in forms table.
     * @param query Form SQL Query.
     * 
     * @return SQL Query.
     */
    public static function scopeAssigned($query) {
        if(Auth::user()->user_type == '3') {
            $clinic = Clinician::where('user_id', Auth::user()->id)->first();
            $query = $query->where('clinician_id', $clinic->id);
        } else if(Auth::user()->user_type == '4') {
            $patient = Patient::where('user_id', Auth::user()->id)->first();

            // $clinitians = ClinicianPatient::where('patient_id', $patient->id)->pluck('clinician_id')->toArray();
            // $query = $query->whereIn('clinician_id', $clinitians);
            $query = $query->where('patient_id', $patient->id);
        }

        return $query;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function clinician() {
        return $this->belongsTo(Clinician::class);
    }

    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function meeting() {
        return $this->belongsTo(CrmMeeting::class, 'session_id');
    }
}
