<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'publication_partner',
        'submission_deadline',
        'acceptance_date',
        'camera_ready_deadline',
        'event_website',
        'organizer',
        'contact_email',
        'status',
    ];

    // Relationships (example: if Event belongs to a Category)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function conference_submission()
    {
        return $this->belongsTo(ConferenceSubmission::class);
    }

    // Optional: Get topics through the category
    // public function topics()
    // {
    //     return $this->category ? $this->category->topics() : collect();
    // }

    // public function topics()
    // {
    //     return $this->belongsToMany(Topic::class, 'category_topic', 'event_topic');
    // }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'event_topic');
    }
}