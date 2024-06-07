<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignedForm extends Model
{
    use HasFactory;


    protected $fillable = [ 
        'id', 
        'patient_id', 
        'form_id', 
        'user_id', 
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
