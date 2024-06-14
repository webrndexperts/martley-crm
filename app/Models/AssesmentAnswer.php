<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssesmentAnswer extends Model
{
    use HasFactory;
    protected $fillable = [ 'id', 'assesment_id', 'user_id', 'question_id', 'answer' ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function question() {
        return $this->belongsTo(CRMAssessmentQuestion::class, 'question_id');
    }

    public function assessment() {
        return $this->belongsTo(CRMAssessment::class, 'assesment_id');
    }
}
