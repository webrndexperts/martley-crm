<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clinician;
use Auth;

class Patient extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinicianPatients()
    {
        return $this->hasMany(ClinicianPatient::class);
    }

    public function clinicians()
    {
        return $this->belongsToMany(Clinician::class, 'clinician_patients', 'patient_id', 'clinician_id');
    }

    public function assignedForms()
    {
        return $this->hasMany(AssignedForm::class);
    }
    public function AssignedAssessment()
    {
        return $this->hasMany(AssignedAssessment::class);
    }
    
    /**
     * Function to add scope in forms table.
     * @param query Form SQL Query.
     * 
     * @return SQL Query.
     */
    public static function scopeAssigned($query) {
        if(Auth::user()->user_type != '2') {
            $user = Clinician::where('user_id' , Auth::user()->id)->first();

            $query = $query->leftJoin('clinician_patients as a', 'a.patient_id', '=', 'patients.id')
                ->where('a.clinician_id', $user->id)
                ->select('patients.*');
        }

        return $query;
    }
}
