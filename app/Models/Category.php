<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function topics()
{
    return $this->belongsToMany(Topic::class, 'category_topic');
}

    public function events()
{
    return $this->hasMany(Event::class);
}
}

