<?php

namespace App\Http\Controllers\Author;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\JournalSubmission;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Journal;
use App\Models\JournalReview;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Notifications\ReviewDecisionNotification;
use Illuminate\Support\Str;

class JournalSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => 'required|integer|exists:topics,id',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'paper' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'department_rule_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'professor_rule_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'event_id' => 'required|integer'
        ]);
        $validated['user_id'] = Auth::id();
        $authorCategory = Category::where('name', 'journal')->first();
        $validated['category_id'] =  $authorCategory->id;
        // Handle file uploads
        if ($request->hasFile('paper')) {
            $validated['paper_path'] = $request->file('paper')->store('journals/papers', 'public');
        }

        if ($request->hasFile('department_rule_file')) {
            $validated['department_rule_path'] = $request->file('department_rule_file')->store('journals/dept_rules', 'public');
        }

        if ($request->hasFile('professor_rule_file')) {
            $validated['professor_rule_path'] = $request->file('professor_rule_file')->store('journals/prof_rules', 'public');
        }

        JournalSubmission::create($validated);
        return redirect()->back()->with('success', 'Journal submitted successfully!');
    }

    public function update(Request $request, $id)
    {
        // Find submission or fail
        $submission = JournalSubmission::findOrFail($id);

        // Validation rules
        $rules = [

            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'paper' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // max 10MB
            'department_rule_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'professor_rule_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];

        $validated = $request->validate($rules);
        // Track related review row (assumes 1:1 relation for simplicity)
        $review = JournalReview::where('journal_submission_id', $id)->first();
        // adjust if relationship is different

        if ($submission->edit_count >= 3) {
            $review->evaluation = 'reject';
        }

        $review->save();

        $submission->edit_count += 1;

        // Update basic fields

        $submission->abstract = $validated['abstract'];
        $submission->keywords = $validated['keywords'];

        // Handle file uploads
        if ($request->hasFile('paper')) {
            // Delete old paper if exists
            if ($submission->paper_path && Storage::disk('public')->exists($submission->paper_path)) {
                Storage::disk('public')->delete($submission->paper_path);
            }
            $paperPath = $request->file('paper')->store('journals/papers', 'public');
            $submission->paper_path = $paperPath;
        }

        if ($request->hasFile('department_rule_file')) {
            if ($submission->department_rule_path && Storage::disk('public')->exists($submission->department_rule_path)) {
                Storage::disk('public')->delete($submission->department_rule_path);
            }
            $deptRulePath = $request->file('department_rule_file')->store('journals/dept_rules', 'public');
            $submission->department_rule_path = $deptRulePath;
        }

        if ($request->hasFile('professor_rule_file')) {
            if ($submission->professor_rule_path && Storage::disk('public')->exists($submission->professor_rule_path)) {
                Storage::disk('public')->delete($submission->professor_rule_path);
            }
            $profRulePath = $request->file('professor_rule_file')->store('journals/prof_rules', 'public');
            $submission->professor_rule_path = $profRulePath;
        }

        $submission->save();
        if ($submission && ($author = $submission->author)) {
            // Prepare notification data
            $notificationData = (new ReviewDecisionNotification($submission, $review))->toDatabase($author);

            // Try to find an existing notification for this submission + type
            $existing = DB::table('notifications')
                ->where('notifiable_id', $author->id)
                ->where('notifiable_type', get_class($author))
                ->where('type', ReviewDecisionNotification::class)
                ->where('data->submission_id', $submission->id)
                ->first();

            if ($existing) {
                // Update the existing notification
                DB::table('notifications')->where('id', $existing->id)->update([
                    'data' => json_encode($notificationData),
                    'updated_at' => now(),
                    'read_at' => null // Optionally reset read status
                ]);
            } else {
                // Create a new notification
                DB::table('notifications')->insert([
                    'id' => Str::uuid()->toString(),
                    'type' => ReviewDecisionNotification::class,
                    'notifiable_type' => get_class($author),
                    'notifiable_id' => $author->id,
                    'data' => json_encode($notificationData),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return redirect()->back()
            ->with('success', 'Journal submission updated successfully.');
    }
}
