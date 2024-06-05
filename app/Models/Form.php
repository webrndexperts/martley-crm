<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormAnswer;
use App\Models\FormField;
use App\Models\User;

class Form extends Model
{
    use HasFactory;

    public function fields() {
        return $this->hasMany(FormField::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
