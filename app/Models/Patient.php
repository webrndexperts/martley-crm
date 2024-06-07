<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
}
