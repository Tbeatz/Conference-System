<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Journal;
use Illuminate\Http\Request;
use App\Models\JournalSubmission;
use App\Models\User;
use App\Models\ReviewJournalSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\JournalReview;
use App\Notifications\ReviewDecisionNotification;

class ReviewJournalScheduleController extends Controller
{
    public function viewjournalschedule(Request $request)
    {
        $schedules = ReviewJournalSchedule::all();
        return view('admin.reviewer.viewjournalschedule', compact('schedules'));
    }
    public function journalschedule(Request $request)
    {
        $topicId = $request->input('topic_id'); // Selected topic ID

        // Get all papers with topics loaded
        $allPapers = JournalSubmission::with('topics')->get();

        // Extract unique topic models from all papers
        $topics = $allPapers->pluck('topics')->unique('id')->values();

        $papers = collect();
        $reviewers = collect();

        if ($topicId) {
            // 1. Filter papers that match the selected topic and have a valid file
            $papers = JournalSubmission::where('topic_id', $topicId)
                ->whereNotNull('paper_path')
                ->where('paper_path', '<>', '')
                ->whereDoesntHave('reviewSchedule') // ensure no record in review table
                ->get();



            // 2. Get the selected topic name
            $selectedTopicName = optional(\App\Models\Topic::find($topicId))->name;

            // 3. Filter reviewers by field containing the topic name and not scheduled more than 3 times

            $reviewers = User::whereHas('roles', function ($query) {
                $query->where('name', 'reviewer');
            })
                ->whereRaw("FIND_IN_SET(?, field)", [$selectedTopicName])
                ->whereNotIn('id', function ($query) {
                    $query->select('reviewer_id')
                        ->from(DB::raw('(
                SELECT reviewer1_id AS reviewer_id FROM review_journal_schedules WHERE reviewer1_id IS NOT NULL
                UNION ALL
                SELECT reviewer2_id FROM review_journal_schedules WHERE reviewer2_id IS NOT NULL
                UNION ALL
                SELECT reviewer3_id FROM review_journal_schedules WHERE reviewer3_id IS NOT NULL
                UNION ALL
                SELECT reviewer1_id FROM review_conference_schedules WHERE reviewer1_id IS NOT NULL
                UNION ALL
                SELECT reviewer2_id FROM review_conference_schedules WHERE reviewer2_id IS NOT NULL
                UNION ALL
                SELECT reviewer3_id FROM review_conference_schedules WHERE reviewer3_id IS NOT NULL
            ) as all_reviewers'))
                        ->groupBy('reviewer_id')
                        ->havingRaw('COUNT(*) >= 3');
                })
                ->get();
        }

        return view('admin.reviewer.journalschedule', compact('topics', 'papers', 'reviewers', 'topicId'));
    }




    public function store(Request $request)
    {
        Log::info($request->all());
        // dd($request->all());
        $request->validate([
            'journal_submission_id' => 'required|exists:journal_submissions,id',
            'reviewer1_id' => 'required|exists:users,id',
            'reviewer2_id' => 'required|exists:users,id',
            'reviewer3_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);


        ReviewJournalSchedule::create($request->all());

        return redirect()->route('admin.schedule.journal')->with('success', 'Schedule created!');
    }

    public function edit($id)
    {
        $submission = JournalSubmission::find($id);
        $selectedTopicName = optional(\App\Models\Topic::find($submission->topic_id))->name;
        $schedules = ReviewJournalSchedule::findOrFail($id);

        $reviewers = User::whereHas('roles', function ($query) {
            $query->where('name', 'reviewer');
        })
            ->whereRaw("FIND_IN_SET(?, field)", [$selectedTopicName])
            ->whereNotIn('id', function ($query) {
                $query->select('reviewer_id')
                    ->from(DB::raw('(
                SELECT reviewer1_id AS reviewer_id FROM review_journal_schedules WHERE reviewer1_id IS NOT NULL
                UNION ALL
                SELECT reviewer2_id FROM review_journal_schedules WHERE reviewer2_id IS NOT NULL
                UNION ALL
                SELECT reviewer3_id FROM review_journal_schedules WHERE reviewer3_id IS NOT NULL
                UNION ALL
                SELECT reviewer1_id FROM review_conference_schedules WHERE reviewer1_id IS NOT NULL
                UNION ALL
                SELECT reviewer2_id FROM review_conference_schedules WHERE reviewer2_id IS NOT NULL
                UNION ALL
                SELECT reviewer3_id FROM review_conference_schedules WHERE reviewer3_id IS NOT NULL
            ) as all_reviewers'))
                    ->groupBy('reviewer_id')
                    ->havingRaw('COUNT(*) >= 3');
            })
            ->get();

        return view('admin.reviewer.editjournal', compact('schedules', 'reviewers'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'paper' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // max 20MB
            'reviewer1_id' => 'nullable|exists:users,id',
            'reviewer2_id' => 'nullable|exists:users,id',
            'reviewer3_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $schedule = ReviewJournalSchedule::findOrFail($id);

        $schedule->update($request->only(['reviewer1_id', 'reviewer2_id', 'reviewer3_id', 'start_date', 'end_date']));

        $journalSubmission = JournalSubmission::findOrFail($schedule->journal_submission_id);

        // Update JournalSubmission if a new paper is uploaded
        if ($request->hasFile('paper')) {
            $filePath = $request->file('paper')->store('journals/papers', 'public');
            $journalSubmission->paper_path = $filePath;
            $journalSubmission->save();
        }


        return redirect()->route('admin.schedule.journalview')->with('success', 'Schedule updated successfully!');
    }


    // Delete user
    public function destroy($id)
    {
        $schedule = ReviewJournalSchedule::findOrFail($id);

        $schedule->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
    public function upload($id)
    {
        $data = ReviewJournalSchedule::findOrFail($id);
        if (!is_null($data->status)) {
            $data->update([
                'status' => null
            ]);
        } else {
            $data->update([
                'status' => 'send'
            ]);
        }

        return redirect()->back()->with('success', 'Paper send successfully!');
    }
    public function destroyReturnJournal($id)
    {
        $review = JournalReview::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Journal review deleted successfully.');
    }
    public function toggleStatus($id)
    {
        $review = JournalReview::findOrFail($id);
        $review->status = $review->status === 'sent' ? 'draft' : 'sent';
        $review->save();
        if ($review->status === 'sent') {

            $submission = $review->journalSubmission; // or conferenceSubmission if appropriate

            if ($submission && ($author = $submission->author)) {
                $author->notify(new ReviewDecisionNotification($submission, $review));
            }
            // adjust if needed


        }
        return redirect()->back()->with('success', 'Review status updated.');
    }
}