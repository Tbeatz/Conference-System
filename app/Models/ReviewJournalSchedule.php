<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewJournalSchedule extends Model
{
    protected $fillable = [
        'journal_submission_id',
        'reviewer1_id',
        'reviewer2_id',
        'reviewer3_id',
        'start_date',
        'end_date',
        'status'
    ];

    public function journalSubmission()
    {
        return $this->belongsTo(JournalSubmission::class);
    }

    public function reviewer1()
    {
        return $this->belongsTo(User::class, 'reviewer1_id');
    }

    public function reviewer2()
    {
        return $this->belongsTo(User::class, 'reviewer2_id');
    }

    public function reviewer3()
    {
        return $this->belongsTo(User::class, 'reviewer3_id');
    }

    public function submission()
    {
        return $this->belongsTo(JournalSubmission::class, 'journal_submission_id'); // <- correct FK
    }
}
