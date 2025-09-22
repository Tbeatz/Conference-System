<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'topic_id',
        'description',
        'paper_path',
        'start_date',
        'end_date',
        'publication_date',
        'journal_website',
        'reviewer_id',
        'author_id',
        'contact_email',
        'status',
    ];

    /**
     * Relationships
     */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
