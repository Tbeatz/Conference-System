<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationInfo extends Model
{
    protected $fillable = ['label', 'value', 'type'];
}
