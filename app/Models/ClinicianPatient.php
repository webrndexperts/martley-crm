<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicianPatient extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinician_id', 
        'patient_id', 
        'updated_at', 
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinician()
    {
        return $this->belongsTo(Clinician::class, 'clinician_id');
    }

    public function patientUser()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function clinicianUser()
    {
        return $this->belongsTo(User::class, 'clinician_id');
    }

}
