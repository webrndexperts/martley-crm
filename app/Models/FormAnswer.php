<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class FormAnswer extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'form_id', 'user_id', 'form_field_id', 'answer' ];

    /**
     * Function to add scope in forms table.
     * @param query Form SQL Query.
     * 
     * @return SQL Query.
     */
    public static function scopeAssigned($query) {
        if(Auth::user()->user_type == '3') {
            $clinitian = Clinician::where('user_id', Auth::user()->id)->first();
            $assigned = ClinicianPatient::where('clinician_id', $clinitian->id)->pluck('patient_id')->toArray();
            $patients = Patient::whereIn('id', $assigned)->pluck('user_id')->toArray();

            $query = $query->whereIn('user_id', $patients);
        } elseif (Auth::user()->user_type == '4') {
            $query = $query->whereIn('user_id', Auth::user()->id);
        }

        return $query;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function question() {
        return $this->belongsTo(FormField::class, 'form_field_id');
    }

    public function form() {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
