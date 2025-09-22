<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

//     public function journals()
// {
//     return $this->belongsToMany(Journal::class);
// }

public function categories()
{
    return $this->belongsToMany(Category::class, 'category_topic');
}

public function events()
{
    return $this->belongsToMany(Event::class, 'event_topic');
}


}
