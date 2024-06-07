<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\FormField;

class FormAnswer extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'form_id', 'user_id', 'form_field_id', 'answer' ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function question() {
        return $this->belongsTo(FormField::class, 'form_field_id');
    }
}
