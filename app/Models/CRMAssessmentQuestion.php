<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CRMAssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'question_type',
    ];

}
