<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormAnswer;
use App\Models\FormField;
use App\Models\User;
use Auth;

class Form extends Model
{
    use HasFactory;

    public function fields() {
        return $this->hasMany(FormField::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function submited() {
        return $this->hasOne(FormAnswer::class)->where('form_answers.user_id', Auth::user()->id);
    }

    public function assignedForms()
    {
        return $this->hasMany(AssignedForm::class);
    }
}
