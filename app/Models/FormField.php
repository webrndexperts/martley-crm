<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormAnswer;

class FormField extends Model
{
    use HasFactory;

    protected $fillable = [ 'id', 'form_id', 'type', 'label', 'options' ];

    public function answers() {
        return $this->hasMany(FormAnswer::class, 'form_field_id');
    }
}
