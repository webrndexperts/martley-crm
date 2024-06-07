<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinician extends Model
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

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'clinician_patients', 'clinician_id', 'patient_id');
    }

}

