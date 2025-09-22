<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;
use App\Models\JournalSubmission;
use App\Models\ReviewConferenceSchedule;
use App\Models\ReviewJournalSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ConferenceSubmission;
use App\Models\JournalReview;
use App\Models\ConferenceReview;

// class ReviewerResponseController extends Controller
// {

//     public function downloadConferenceReviewPaper($id)
//     {
//         $schedule = ReviewConferenceSchedule::with('conferenceSubmission')->findOrFail($id);
//         $path = $schedule->conferenceSubmission->paper_path;

//         if (!Storage::disk('public')->exists($path)) {
//             abort(404, 'File not found.');
//         }

//         return Storage::disk('public')->download($path);
//     }
//     public function downloadJournalReviewPaper($id)
//     {
//         $schedule = ReviewJournalSchedule::with('conferenceSubmission')->findOrFail($id);
//         $path = $schedule->journalSubmission->paper_path;

//         if (!Storage::disk('public')->exists($path)) {
//             abort(404, 'File not found.');
//         }

//         return Storage::disk('public')->download($path);
//     }

//     public function updateConference(Request $request, $id)
//     {
//         $request->validate([
//             'evaluation' => 'required|in:acceptable,minor_revisions,major_revisions,reject',
//             'reviewer_comments' => 'required|string|min:10',
//         ]);

//         $review = ConferenceReview::where('conference_submission_id', $id)->first();

//         if (!$review) {
//             // Create new review row with current user as reviewer1
//             $review = ConferenceReview::create([
//                 'conference_submission_id' => $id,
//                 'reviewer1_id' => Auth::id(),
//                 'evaluation' => $request->evaluation, // initial, may be overwritten
//                 'reviewer_comments' => $request->reviewer_comments,
//                 'status' => 'draft',
//             ]);
//         } else {
//             $userId = Auth::id();
//             $evaluationChanged = false;

//             if ($review->reviewer1_id === null) {
//                 $review->reviewer1_id = $userId;
//                 $evaluationChanged = true;
//             } elseif ($review->reviewer2_id === null) {
//                 $review->reviewer2_id = $userId;
//                 $evaluationChanged = true;
//             } elseif ($review->reviewer3_id === null) {
//                 $review->reviewer3_id = $userId;
//                 $evaluationChanged = true;
//             } else {
//                 return back()->with('error', 'All reviewers already assigned.');
//             }

//             if ($evaluationChanged) {
//                 // Append new reviewer comment
//                 $review->reviewer_comments .= "\n[{$userId}] " . $request->reviewer_comments;

//                 // Store the current user's evaluation separately
//                 // We simulate storing multiple reviewer decisions in this array
//                 $evaluations = [];

//                 // Existing evaluation already stored
//                 if (!empty($review->evaluation)) {
//                     $evaluations[] = $review->evaluation;
//                 }

//                 // Add the new evaluation just submitted
//                 $evaluations[] = $request->evaluation;

//                 // Normalize to collection
//                 $evalCollection = collect($evaluations)->filter();

//                 // Final decision logic:
//                 if ($evalCollection->contains('reject')) {
//                     $review->evaluation = 'reject';
//                 } elseif (
//                     $evalCollection->count() === 3 &&
//                     $evalCollection->every(fn($e) => $e === 'accept')
//                 ) {
//                     $review->evaluation = 'accept';
//                 } elseif ($evalCollection->count() >= 2) {
//                     // Use majority vote
//                     $frequencies = $evalCollection->countBy();
//                     $review->evaluation = $frequencies->sortDesc()->keys()->first(); // most frequent value
//                 } else {
//                     $review->evaluation = $request->evaluation; // fallback
//                 }

//                 $review->save();
//             }
//         }

//         return redirect()->back()->with('success', 'Conference review submitted successfully.');
//     }

//     public function updateJournal(Request $request, $id)
//     {
//         $request->validate([
//             'evaluation' => 'required|in:acceptable,minor_revisions,major_revisions,reject',
//             'reviewer_comments' => 'required|string|min:10',
//         ]);

//         $review = JournalReview::where('journal_submission_id', $id)->first();

//         if (!$review) {
//             // Create new review row with current user as reviewer1
//             $review = JournalReview::create([
//                 'journal_submission_id' => $id,
//                 'reviewer1_id' => Auth::id(),
//                 'evaluation' => $request->evaluation, // initial, may be overwritten
//                 'reviewer_comments' => $request->reviewer_comments,
//                 'status' => 'draft',
//             ]);
//         } else {
//             $userId = Auth::id();
//             $evaluationChanged = false;

//             if ($review->reviewer1_id === null) {
//                 $review->reviewer1_id = $userId;
//                 $evaluationChanged = true;
//             } elseif ($review->reviewer2_id === null) {
//                 $review->reviewer2_id = $userId;
//                 $evaluationChanged = true;
//             } elseif ($review->reviewer3_id === null) {
//                 $review->reviewer3_id = $userId;
//                 $evaluationChanged = true;
//             } else {
//                 return back()->with('error', 'All reviewers already assigned.');
//             }

//             if ($evaluationChanged) {
//                 // Append new reviewer comment
//                 $review->reviewer_comments .= "\n[{$userId}] " . $request->reviewer_comments;

//                 // Store the current user's evaluation separately
//                 // We simulate storing multiple reviewer decisions in this array
//                 $evaluations = [];

//                 // Existing evaluation already stored
//                 if (!empty($review->evaluation)) {
//                     $evaluations[] = $review->evaluation;
//                 }

//                 // Add the new evaluation just submitted
//                 $evaluations[] = $request->evaluation;

//                 // Normalize to collection
//                 $evalCollection = collect($evaluations)->filter();

//                 // Final decision logic:
//                 if ($evalCollection->contains('reject')) {
//                     $review->evaluation = 'reject';
//                 } elseif (
//                     $evalCollection->count() === 3 &&
//                     $evalCollection->every(fn($e) => $e === 'accept')
//                 ) {
//                     $review->evaluation = 'accept';
//                 } elseif ($evalCollection->count() >= 2) {
//                     // Use majority vote
//                     $frequencies = $evalCollection->countBy();
//                     $review->evaluation = $frequencies->sortDesc()->keys()->first(); // most frequent value
//                 } else {
//                     $review->evaluation = $request->evaluation; // fallback
//                 }

//                 $review->save();
//             }
//         }

//         return redirect()->back()->with('success', 'Review submitted successfully.');
//     }
// }

// <?php

// namespace App\Http\Controllers\Reviewer;

// use App\Http\Controllers\Controller;
// use App\Models\Conference;
// use Illuminate\Http\Request;
// use App\Models\ReviewConferenceSchedule;
// use App\Models\ConferenceSubmission;
// use App\Models\ConferenceReview;
// use App\Models\User;
// use App\Models\Topic;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\DB;

class ReviewerResponseController extends Controller
{
    public function downloadConferenceReviewPaper($id)
    {
        $schedule = ReviewConferenceSchedule::with('conferenceSubmission')->findOrFail($id);
        $path = $schedule->conferenceSubmission->paper_path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($path);
    }

    // public function updateConference(Request $request, $id)
    // {
    //     $request->validate([
    //         'evaluation' => 'required|in:acceptable,minor_revisions,major_revisions,reject',
    //         'reviewer_comments' => 'required|string|min:10',
    //     ]);

    //     $review = ConferenceReview::where('conference_submission_id', $id)->first();

    //     if (!$review) {
    //         $review = ConferenceReview::create([
    //             'conference_submission_id' => $id,
    //             'reviewer1_id' => Auth::id(),
    //             'evaluation' => $request->evaluation,
    //             'reviewer_comments' => $request->reviewer_comments,
    //             'status' => 'draft',
    //         ]);
    //     } else {
    //         $userId = Auth::id();
    //         $evaluationChanged = false;

    //         if ($review->reviewer1_id === null) {
    //             $review->reviewer1_id = $userId;
    //             $evaluationChanged = true;
    //         } elseif ($review->reviewer2_id === null) {
    //             $review->reviewer2_id = $userId;
    //             $evaluationChanged = true;
    //         } elseif ($review->reviewer3_id === null) {
    //             $review->reviewer3_id = $userId;
    //             $evaluationChanged = true;
    //         } else {
    //             return back()->with('error', 'All reviewers already assigned.');
    //         }

    //         if ($evaluationChanged) {
    //             $review->reviewer_comments .= "\n[{$userId}] " . $request->reviewer_comments;

    //             $evaluations = [];
    //             if (!empty($review->evaluation)) {
    //                 $evaluations[] = $review->evaluation;
    //             }
    //             $evaluations[] = $request->evaluation;

    //             $evalCollection = collect($evaluations)->filter();

    //             if ($evalCollection->contains('reject')) {
    //                 $review->evaluation = 'reject';
    //             } elseif ($evalCollection->count() === 3 && $evalCollection->every(fn($e) => $e === 'acceptable')) {
    //                 $review->evaluation = 'acceptable';
    //             } elseif ($evalCollection->count() >= 2) {
    //                 $frequencies = $evalCollection->countBy();
    //                 $review->evaluation = $frequencies->sortDesc()->keys()->first();
    //             } else {
    //                 $review->evaluation = $request->evaluation;
    //             }

    //             $review->save();
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Conference review submitted successfully.');
    // }

    //     public function updateConference(Request $request, $id)
    // {
    //     $request->validate([
    //         'evaluation' => 'required|in:acceptable,minor_revisions,major_revisions,reject',
    //         'reviewer_comments' => 'required|string|min:10',
    //     ]);

    //     $review = ConferenceReview::where('conference_submission_id', $id)->first();
    //     $userId = Auth::id();

    //     if (!$review) {
    //         // create new review row, assign to reviewer1
    //         $review = ConferenceReview::create([
    //             'conference_submission_id' => $id,
    //             'reviewer1_id' => $userId,
    //             'evaluation' => $request->evaluation,
    //             'reviewer_comments' => $request->reviewer_comments,
    //             'status' => 'draft',
    //         ]);
    //     } else {
    //         // check if this user is already reviewer1/2/3
    //         if ($review->reviewer1_id === $userId) {
    //             // overwrite reviewer1 comment & evaluation
    //             $review->evaluation = $request->evaluation;
    //             $review->reviewer_comments = "[Reviewer1: {$userId}] " . $request->reviewer_comments;
    //         } elseif ($review->reviewer2_id === $userId) {
    //             $review->evaluation = $request->evaluation;
    //             $review->reviewer_comments = "[Reviewer2: {$userId}] " . $request->reviewer_comments;
    //         } elseif ($review->reviewer3_id === $userId) {
    //             $review->evaluation = $request->evaluation;
    //             $review->reviewer_comments = "[Reviewer3: {$userId}] " . $request->reviewer_comments;
    //         } else {
    //             // assign this user to the next empty reviewer slot
    //             if ($review->reviewer1_id === null) {
    //                 $review->reviewer1_id = $userId;
    //             } elseif ($review->reviewer2_id === null) {
    //                 $review->reviewer2_id = $userId;
    //             } elseif ($review->reviewer3_id === null) {
    //                 $review->reviewer3_id = $userId;
    //             } else {
    //                 return back()->with('error', 'All reviewers already assigned.');
    //             }
    //             $review->evaluation = $request->evaluation;
    //             $review->reviewer_comments = "[{$userId}] " . $request->reviewer_comments;
    //         }

    //         $review->status = 'draft';
    //         $review->save();
    //     }

    //     return redirect()->back()->with('success', 'Conference review submitted successfully.');
    // }

// public function updateConference(Request $request, $id)
// {
//     $request->validate([
//         'evaluation' => 'required|in:acceptable,minor_revisions,major_revisions,reject',
//         'reviewer_comments' => 'required|string|min:10',
//     ]);

//     $review = ConferenceReview::where('conference_submission_id', $id)->first();
//     $userId = Auth::id();
//     $userComment = "[Reviewer {$userId}] " . $request->reviewer_comments;

//     if (!$review) {
//         // create new review row, assign to reviewer1
//         $review = ConferenceReview::create([
//             'conference_submission_id' => $id,
//             'reviewer1_id' => $userId,
//             'evaluation' => $request->evaluation,
//             'reviewer_comments' => $userComment,
//             'status' => 'draft',
//         ]);
//     } else {
//         // 1. assign reviewer slot if not already assigned
//         if ($review->reviewer1_id === $userId || $review->reviewer2_id === $userId || $review->reviewer3_id === $userId) {
//             // already assigned, just update the comment
//         } else {
//             if ($review->reviewer1_id === null) {
//                 $review->reviewer1_id = $userId;
//             } elseif ($review->reviewer2_id === null) {
//                 $review->reviewer2_id = $userId;
//             } elseif ($review->reviewer3_id === null) {
//                 $review->reviewer3_id = $userId;
//             } else {
//                 return back()->with('error', 'All reviewers already assigned.');
//             }
//         }

//         // 2. build all reviewer comments
//         $allComments = [];

//         if ($review->reviewer1_id) {
//             $allComments[] = $review->reviewer1_id == $userId ? $userComment : "[Reviewer {$review->reviewer1_id}] " . $request->reviewer_comments;
//         }

//         if ($review->reviewer2_id) {
//             $allComments[] = $review->reviewer2_id == $userId ? $userComment : "[Reviewer {$review->reviewer2_id}] " . $request->reviewer_comments;
//         }

//         if ($review->reviewer3_id) {
//             $allComments[] = $review->reviewer3_id == $userId ? $userComment : "[Reviewer {$review->reviewer3_id}] " . $request->reviewer_comments;
//         }

//         // 3. store concatenated comments
//         $review->reviewer_comments = implode("\n", $allComments);

//         // 4. update latest evaluation
//         $review->evaluation = $request->evaluation;
//         $review->status = 'draft';
//         $review->save();
//     }

//     return redirect()->back()->with('success', 'Conference review submitted successfully.');
// }
public function updateConference(Request $request, $id)
{
    $request->validate([
        'evaluation' => 'required|in:acceptable,minor_revisions,major_revisions,reject',
        'reviewer_comments' => 'required|string|min:10',
    ]);

    $review = ConferenceReview::where('conference_submission_id', $id)->first();
    $userId = Auth::id();

    if (!$review) {
        // Create new review with reviewer1 as the first submitter
        $allComments = [
            $userId => $request->reviewer_comments
        ];

        $review = ConferenceReview::create([
            'conference_submission_id' => $id,
            'reviewer1_id' => $userId,
            'evaluation' => $request->evaluation,
            'reviewer_comments' => json_encode($allComments),
            'status' => 'draft',
        ]);
    } else {
        // Load existing comments
        $allComments = $review->reviewer_comments ? json_decode($review->reviewer_comments, true) : [];

        // Assign reviewer to empty slot if not already assigned
        if ($review->reviewer1_id === null) {
            $review->reviewer1_id = $userId;
        } elseif ($review->reviewer2_id === null && $review->reviewer1_id != $userId) {
            $review->reviewer2_id = $userId;
        } elseif ($review->reviewer3_id === null && $review->reviewer1_id != $userId && $review->reviewer2_id != $userId) {
            $review->reviewer3_id = $userId;
        }

        // Update or overwrite this reviewer's comment
        $allComments[$userId] = $request->reviewer_comments;

        // Update evaluation (optional: could use majority vote logic if needed)
        $review->evaluation = $request->evaluation;
        $review->reviewer_comments = json_encode($allComments);
        $review->status = 'draft';
        $review->save();
    }

    return redirect()->back()->with('success', 'Conference review submitted successfully.');
}
// public function updateConference(Request $request, $id)
// {
//     $request->validate([
//         'evaluation' => 'required|in:acceptable,minor_revisions,major_revisions,reject',
//         'reviewer_comments' => 'required|string|min:10',
//     ]);

//     $userId = Auth::id();
//     $review = ConferenceReview::where('conference_submission_id', $id)->first();

//     if (!$review) {
//         // New review row
//         $allComments = [
//             $userId => $request->reviewer_comments
//         ];

//         $review = ConferenceReview::create([
//             'conference_submission_id' => $id,
//             'reviewer1_id' => $userId,
//             'evaluation' => $request->evaluation,
//             'reviewer_comments' => json_encode($allComments),
//             'status' => 'draft',
//         ]);
//     } else {
//         // Load existing comments
//         $allComments = $review->reviewer_comments ? json_decode($review->reviewer_comments, true) : [];

//         // Assign reviewer to empty slot if not already assigned
//         if ($review->reviewer1_id === null) {
//             $review->reviewer1_id = $userId;
//         } elseif ($review->reviewer2_id === null && $review->reviewer1_id != $userId) {
//             $review->reviewer2_id = $userId;
//         } elseif ($review->reviewer3_id === null && $review->reviewer1_id != $userId && $review->reviewer2_id != $userId) {
//             $review->reviewer3_id = $userId;
//         }

//         // Overwrite this reviewer's comment with latest submission
//         $allComments[$userId] = $request->reviewer_comments;

//         // Update evaluation based on all reviewers' evaluations
//         // Here we could implement majority voting
//         $evaluations = $allComments; // key = reviewer_id, value = comment
//         $evaluationCounts = [];

//         // Let's assume you store evaluation for each reviewer separately in JSON as well
//         // For simplicity, using the latest evaluation submitted for this reviewer
//         if (!$review->reviewer_evaluations) {
//             $reviewerEvaluations = [];
//         } else {
//             $reviewerEvaluations = json_decode($review->reviewer_evaluations, true);
//         }

//         $reviewerEvaluations[$userId] = $request->evaluation;

//         // Count each type of evaluation
//         foreach ($reviewerEvaluations as $eval) {
//             if (isset($evaluationCounts[$eval])) {
//                 $evaluationCounts[$eval]++;
//             } else {
//                 $evaluationCounts[$eval] = 1;
//             }
//         }

//         // Determine majority evaluation
//         arsort($evaluationCounts); // sort descending by count
//         $finalEvaluation = key($evaluationCounts); // evaluation with most votes

//         // Save all
//         $review->reviewer_comments = json_encode($allComments);
//         $review->reviewer_evaluations = json_encode($reviewerEvaluations);
//         $review->evaluation = $finalEvaluation;
//         $review->status = 'draft';
//         $review->save();
//     }

//     return redirect()->back()->with('success', 'Conference review submitted successfully.');
// }
// public function updateConference(Request $request, $id)
// {
//     $request->validate([
//         'evaluation' => 'required|in:acceptable,minor_revisions,major_revisions,reject',
//         'reviewer_comments' => 'required|string|min:10',
//     ]);

//     $userId = Auth::id();
//     $review = ConferenceReview::where('conference_submission_id', $id)->first();

//     if (!$review) {
//         // New review
//         $allComments = [
//             $userId => [
//                 'comment' => $request->reviewer_comments,
//                 'evaluation' => $request->evaluation,
//             ]
//         ];

//         $review = ConferenceReview::create([
//             'conference_submission_id' => $id,
//             'reviewer1_id' => $userId,
//             'reviewer_comments' => json_encode($allComments),
//             'evaluation' => $request->evaluation,
//             'status' => 'draft',
//         ]);
//     } else {
//         // Load existing reviewer comments
//         $allComments = $review->reviewer_comments ? json_decode($review->reviewer_comments, true) : [];

//         // Assign reviewer to empty slot if not already assigned
//         if ($review->reviewer1_id === null) {
//             $review->reviewer1_id = $userId;
//         } elseif ($review->reviewer2_id === null && $review->reviewer1_id != $userId) {
//             $review->reviewer2_id = $userId;
//         } elseif ($review->reviewer3_id === null && $review->reviewer1_id != $userId && $review->reviewer2_id != $userId) {
//             $review->reviewer3_id = $userId;
//         }

//         // Update this reviewer's comment & evaluation
//         $allComments[$userId] = [
//             'comment' => $request->reviewer_comments,
//             'evaluation' => $request->evaluation,
//         ];

//         // Calculate majority evaluation from all reviewers
//         $evaluationCounts = [];
//         foreach ($allComments as $data) {
//             $eval = $data['evaluation'];
//             if (isset($evaluationCounts[$eval])) {
//                 $evaluationCounts[$eval]++;
//             } else {
//                 $evaluationCounts[$eval] = 1;
//             }
//         }

//         arsort($evaluationCounts); // most frequent first
//         $finalEvaluation = key($evaluationCounts);

//         // Save all
//         $review->reviewer_comments = json_encode($allComments);
//         $review->evaluation = $finalEvaluation;
//         $review->status = 'draft';
//         $review->save();
//     }

//     return redirect()->back()->with('success', 'Conference review submitted successfully.');
// }
// public function updateConference(Request $request, $id)
// {
//     $request->validate([
//         'evaluation' => 'required|in:acceptable,minor_revisions,major_revisions,reject',
//         'reviewer_comments' => 'required|string|min:10',
//     ]);

//     $userId = Auth::id();
//     $review = ConferenceReview::where('conference_submission_id', $id)->first();

//     if (!$review) {
//         // New review
//         $allComments = [
//             [
//                 'comment' => $request->reviewer_comments,
//                 'evaluation' => $request->evaluation,
//             ]
//         ];

//         $review = ConferenceReview::create([
//             'conference_submission_id' => $id,
//             'reviewer1_id' => $userId, // reviewer slot assignment is optional, ID is internal only
//             'reviewer_comments' => json_encode($allComments),
//             'evaluation' => $request->evaluation,
//             'status' => 'draft',
//         ]);
//     } else {
//         // Load existing comments
//         $allComments = $review->reviewer_comments ? json_decode($review->reviewer_comments, true) : [];

//         // Append current reviewer comment
//         $allComments[] = [
//             'comment' => $request->reviewer_comments,
//             'evaluation' => $request->evaluation,
//         ];

//         // Calculate majority evaluation from all reviewers
//         $evaluationCounts = [];
//         foreach ($allComments as $data) {
//             $eval = $data['evaluation'];
//             if (isset($evaluationCounts[$eval])) {
//                 $evaluationCounts[$eval]++;
//             } else {
//                 $evaluationCounts[$eval] = 1;
//             }
//         }

//         arsort($evaluationCounts); // most frequent first
//         $finalEvaluation = key($evaluationCounts);

//         // Save all
//         $review->reviewer_comments = json_encode($allComments);
//         $review->evaluation = $finalEvaluation;
//         $review->status = 'draft';
//         $review->save();
//     }

//     return redirect()->back()->with('success', 'Conference review submitted successfully.');
// }







    /**
     * Show the evaluation edit form
     */
    public function editConferenceReview($id)
    {
        $schedule = ReviewConferenceSchedule::with('conferenceSubmission')->findOrFail($id);
        $submission = $schedule->conferenceSubmission;
        $selectedTopicName = optional(Topic::find($submission->topic_id))->name;

        $reviewers = User::whereHas('roles', function ($query) {
            $query->where('name', 'reviewer');
        })
            ->whereRaw("FIND_IN_SET(?, field)", [$selectedTopicName])
            ->whereNotIn('id', function ($query) {
                $query->select('reviewer_id')
                    ->from(DB::raw('(
                        SELECT reviewer1_id AS reviewer_id FROM review_conference_schedules WHERE reviewer1_id IS NOT NULL
                        UNION ALL
                        SELECT reviewer2_id FROM review_conference_schedules WHERE reviewer2_id IS NOT NULL
                        UNION ALL
                        SELECT reviewer3_id FROM review_conference_schedules WHERE reviewer3_id IS NOT NULL
                    ) as all_reviewers'))
                    ->groupBy('reviewer_id')
                    ->havingRaw('COUNT(*) >= 3');
            })
            ->get();

        $review = ConferenceReview::where('conference_submission_id', $submission->id)->first();
        $currentEvaluation = $review ? $review->evaluation : null;

        return view('admin.reviewer.editconference', compact('schedule', 'reviewers', 'currentEvaluation'));
    }
}
