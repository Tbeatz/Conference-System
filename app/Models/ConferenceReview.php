<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConferenceReview extends Model
{
    protected $fillable = [
        'conference_submission_id',
        'reviewer1_id',
        'reviewer2_id',
        'reviewer3_id',
        'evaluation',
        'reviewer_comments',
        'status',
    ];

    /**
     * The user who reviewed the submission
     */
    public function reviewer1()
    {
        return $this->belongsTo(User::class, 'reviewer1_id');
    }

    /**
     * Reviewer 2 relationship
     */
    public function reviewer2()
    {
        return $this->belongsTo(User::class, 'reviewer2_id');
    }

    /**
     * Reviewer 3 relationship
     */
    public function reviewer3()
    {
        return $this->belongsTo(User::class, 'reviewer3_id');
    }

    /**
     * Get all assigned reviewers as a collection
     */
    public function allReviewers()
    {
        return collect([
            $this->reviewer1,
            $this->reviewer2,
            $this->reviewer3,
        ])->filter();
    }

    /**
     * The journal submission being reviewed
     */
    public function conferenceSubmission()
    {
        return $this->belongsTo(ConferenceSubmission::class);
    }
}