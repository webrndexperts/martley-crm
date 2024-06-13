<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Patient;

class CRMAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
    ];

    /**
     * Function to add scope in forms table.
     * @param query Assesment SQL Query.
     * 
     * @return SQL Query.
     */
    public static function scopeAssigned($query) {
        if(Auth::user()->user_type == '4') {
            $patient = Patient::where('user_id', Auth::user()->id)->first();

            $query = $query->leftJoin('assigned_assessments as a', 'a.assessment_id', '=', 'c_r_m_assessments.id')
                ->where('a.patient_id', $patient->id)
                ->select('c_r_m_assessments.*');
        }

        return $query;
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function AssignedAssessment()
    {
        return $this->hasMany(AssignedAssessment::class);
    }

    public function questions() {
        return $this->hasMany(CRMAssessmentQuestion::class, 'assessment_id');
    }

    public function submited() {
        return $this->hasOne(AssesmentAnswer::class, 'assesment_id')
            ->where('assesment_answers.user_id', Auth::user()->id);
    }

}
