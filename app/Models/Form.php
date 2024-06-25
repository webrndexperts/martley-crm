<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormAnswer;
use App\Models\FormField;
use App\Models\User;
use App\Models\Patient;
use Auth;

class Form extends Model
{
    use HasFactory;

    /**
     * Function to add scope in forms table.
     * @param query Form SQL Query.
     * 
     * @return SQL Query.
     */
    public static function scopeAssigned($query) {
        if(Auth::user()->user_type == '4') {
            $patient = Patient::where('user_id', Auth::user()->id)->first();

            $query = $query->leftJoin('assigned_forms as a', 'a.form_id', '=', 'forms.id')
                ->where('a.patient_id', $patient->id)
                ->select('forms.*');
        }

        return $query;
    }

    public function fields() {
        return $this->hasMany(FormField::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function submited() {
        $query = $this->hasOne(FormAnswer::class);

        if(Auth::user()->user_type != '2') {
            $query = $query->where('form_answers.user_id', Auth::user()->id);
        }

        return $query;
    }

    public function assignedForms()
    {
        return $this->hasMany(AssignedForm::class);
    }

    public function answers() {
        return $this->hasMany(FormAnswer::class, 'form_id');
    }

    public function answer() {
        return $this->hasMany(FormAnswer::class, 'form_id')->where('form_answers.user_id', Auth::user()->id);
    }
}
