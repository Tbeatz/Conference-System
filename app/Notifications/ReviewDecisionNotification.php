<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Event;

class ReviewDecisionNotification extends Notification
{
    protected $submission;
    protected $review;

    public function __construct($submission, $review)
    {
        $this->submission = $submission;
        $this->review = $review;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    // public function toDatabase($notifiable)
    // {
    //     // Convert evaluation to readable form
    //     $decision = match ($this->review->evaluation) {
    //         'acceptable' => 'accepted ✅',
    //         'minor_revisions', 'major_revisions' => 'conditionally accepted (needs revision). This submission has been auto-rejected
    //                                     after 3 revisions.✏️',
    //         'reject' => 'rejected ❌',
    //     };
    //     $event = Event::find($this->submission->event_id);
    //     $cleaned = preg_replace('/\[\d+\]/', '.', $this->review->reviewer_comments);

    //     $topic = $this->submission->topics->name;
    //     $categoryName = $this->submission->category->name ?? 'Submission';
    //     $author = $this->submission->author->name ?? '';
    //     if ($this->review->evaluation == 'acceptable')
    //         return [
    //             'title' => 'Review Result for Your Paper',
    //             'message' => 'Dear [' . $author . '], We are pleased to inform you that your paper entitled “[' . $decision . ']” has been accepted for presentation at the [' . $topic  . '], which will be held on [' . $event->start_date . ']',
    //             'evaluation' => $this->review->evaluation,
    //             'review_id' => $this->review->id,
    //             'submission_id' => $this->submission->id,
    //             'category' => $categoryName,
    //             'type' => 'review_decision',
    //         ];
    //     elseif ($this->review->evaluation == 'minor_revisions' || $this->review->evaluation == 'major_revisions') {
    //         return [
    //             'title' => 'Review Result for Your Paper',
    //             'message' => 'Please prepare the camera-ready version of your paper according to the conference guidelines.',
    //             'evaluation' => $this->review->evaluation,
    //             'review_id' => $this->review->id,
    //             'submission_id' => $this->submission->id,
    //             'category' => $categoryName,
    //             'type' => 'review_decision',
    //         ];
    //     } elseif ($this->review->evaluation == 'reject') {
    //         return [
    //             'title' => 'Review Result for Your Paper',
    //             'message' => 'Thank you for submitting your paper entitled “[' . $decision . ']” to the [' . $topic  . ']. After careful consideration by our program committee, we regret to inform you that your paper has not been accepted for presentation at this year’s conference.',
    //             'evaluation' => $this->review->evaluation,
    //             'review_id' => $this->review->id,
    //             'submission_id' => $this->submission->id,
    //             'category' => $categoryName,
    //             'type' => 'review_decision',
    //         ];
    //     }
    // }

    public function toDatabase($notifiable)
    {
        // Convert evaluation to readable form
        $decision = match ($this->review->evaluation) {
            'acceptable' => 'accepted ✅',
            'minor_revisions', 'major_revisions' => 'conditionally accepted (needs revision) ✏️',
            'reject' => 'rejected ❌',
        };

        $event = Event::find($this->submission->event_id);
        $topic = $this->submission->topics->name;
        $categoryName = $this->submission->category->name ?? 'Submission';
        $author = $this->submission->author->name ?? '';

        // Decode reviewer comments
        $allComments = [];
        if (!empty($this->review->reviewer_comments)) {
            $decoded = json_decode($this->review->reviewer_comments, true);
            if (is_array($decoded)) {
                $allComments = $decoded;
            }
        }

        // Build reviewer comments string
        $commentsText = "";
        foreach ($allComments as $reviewerId => $data) {
            $reviewerName = \App\Models\User::find($reviewerId)->name ?? "Reviewer {$reviewerId}";
            // $commentsText .= "{$data['comment']}\n";
            if (is_array($data) && isset($data['comment'])) {
                // data က array ဖြစ်ပြီး comment key ရှိရင်
                $commentsText .= "{$data['comment']}\n";
            } elseif (is_string($data)) {
                // data က string ဖြစ်ရင် တိုက်ရိုက် append
                $commentsText .= "{$data}\n";
            }
        }

        // Main message depending on evaluation
        if ($this->review->evaluation == 'acceptable') {
            $mainMessage = "Dear [' . $author . '], We are pleased to inform you that your paper entitled “[' . $decision . ']” has been accepted for presentation at the [' . $topic  . '], which will be held on [' . $event->start_date . '].\n\nReviewer Comments:\n{$commentsText}";
        } elseif ($this->review->evaluation == 'minor_revisions' || $this->review->evaluation == 'major_revisions') {
            $mainMessage = "Dear {$author},\nYour paper entitled '{$this->submission->title}' requires revisions. Please prepare the camera-ready version according to the conference guidelines.\n\nReviewer Comments:\n{$commentsText}";
        } else { // reject
            $mainMessage = "Dear {$author},\nThank you for submitting your paper entitled '{$this->submission->title}' to the '{$topic}' conference. After careful consideration, your paper was not accepted.\n\nReviewer Comments:\n{$commentsText}";
        } //{$this->submission->title}

        return [
            'title' => 'Review Result for Your Paper',
            'message' => $mainMessage,
            'evaluation' => $this->review->evaluation,
            'review_id' => $this->review->id,
            'submission_id' => $this->submission->id,
            'category' => $categoryName,
            'type' => 'review_decision',
        ];
    }
}

// class ReviewDecisionNotification extends Notification
// {
//     protected $submission;
//     protected $reviews; // reviewer ၃ ယောက်ရဲ့ reviews

//     public function __construct($submission, $reviews)
//     {
//         $this->submission = $submission;
//         $this->reviews = $reviews; // array or collection of 3 reviews
//     }

//     public function via($notifiable)
//     {
//         return ['database'];
//     }

//     public function toDatabase($notifiable)
//     {
//         // Reviewer feedback တွေထဲက evaluation values တွေယူမယ်
//         $evaluations = $this->reviews->pluck('evaluation')->toArray();

//         // Count each type
//         $acceptCount = collect($evaluations)->where(fn($e) => $e === 'acceptable')->count();
//         $minorCount  = collect($evaluations)->where(fn($e) => $e === 'minor_revisions')->count();
//         $majorCount  = collect($evaluations)->where(fn($e) => $e === 'major_revisions')->count();
//         $rejectCount = collect($evaluations)->where(fn($e) => $e === 'reject')->count();

//         // Apply decision rules
//         $finalDecision = match (true) {
//             $acceptCount === 3 => 'accepted ✅',
//             $acceptCount === 2 && ($minorCount === 1 || $rejectCount === 1) => 'accepted (with minor revision) ✏️',
//             $acceptCount === 1 && $majorCount === 2 => 'major revision 📝',
//             $rejectCount === 2 && $acceptCount === 1 => 'rejected ❌',
//             default => 'undecided',
//         };

//         // Related info
//         $event = Event::find($this->submission->event_id);
//         $topic = $this->submission->topics->name ?? 'Conference';
//         $categoryName = $this->submission->category->name ?? 'Submission';
//         $author = $this->submission->author->name ?? '';

//         // Different messages by decision
//         if ($finalDecision === 'accepted ✅') {
//             return [
//                 'title' => 'Review Result for Your Paper',
//                 'message' => 'Dear [' . $author . '], We are pleased to inform you that your paper has been ' . $finalDecision .
//                              ' for presentation at the [' . $topic  . '], which will be held on [' . $event->start_date . ']',
//                 'evaluation' => $finalDecision,
//                 'submission_id' => $this->submission->id,
//                 'category' => $categoryName,
//                 'type' => 'review_decision',
//             ];
//         } elseif ($finalDecision === 'accepted (with minor revision) ✏️' || $finalDecision === 'major revision 📝') {
//             return [
//                 'title' => 'Review Result for Your Paper',
//                 'message' => 'Please prepare the revised version of your paper according to the reviewers’ comments and conference guidelines.',
//                 'evaluation' => $finalDecision,
//                 'submission_id' => $this->submission->id,
//                 'category' => $categoryName,
//                 'type' => 'review_decision',
//             ];
//         } elseif ($finalDecision === 'rejected ❌') {
//             return [
//                 'title' => 'Review Result for Your Paper',
//                 'message' => 'Thank you for submitting your paper to the [' . $topic  . ']. After careful consideration by our program committee, we regret to inform you that your paper has not been accepted for presentation at this year’s conference.',
//                 'evaluation' => $finalDecision,
//                 'submission_id' => $this->submission->id,
//                 'category' => $categoryName,
//                 'type' => 'review_decision',
//             ];
//         } else {
//             return [
//                 'title' => 'Review Result for Your Paper',
//                 'message' => 'Your paper decision is still under review. Please wait for further updates.',
//                 'evaluation' => $finalDecision,
//                 'submission_id' => $this->submission->id,
//                 'category' => $categoryName,
//                 'type' => 'review_decision',
//             ];
//         }
//     }
// }