<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Journal;
use Illuminate\Http\Request;
use App\Models\JournalSubmission;
use App\Models\Keyword;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JournalManagementController extends Controller
{
    public function journals()
    {
        $user = Auth::user(); // assuming only their own submissions

        $journalSubmissions = JournalSubmission::latest()->get();


        return view('admin.authorpapers.journals', compact('journalSubmissions'));
    }
    public function edit($id)
    {
        $topics = Topic::all();
        $categories = Category::all();
        $allKeywords = Keyword::orderBy('name')->get();
        $submission = JournalSubmission::find($id);

        return view('admin.authorpapers.journalsedit', compact(
            'topics',
            'categories',
            'allKeywords',
            'submission'
        ));
    }


    public function update(Request $request, $id)
    {
        // 🔒 Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'topic_id' => 'required|exists:topics,id',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'paper' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'department_rule_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'professor_rule_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        // 🧾 Find submission
        $submission = JournalSubmission::findOrFail($id);

        // 📝 Update basic fields
        $submission->abstract = $request->abstract;
        $submission->keywords = $request->keywords;
        $submission->topic_id = $request->topic_id;
        $submission->start_date = $request->start_date;
        $submission->end_date = $request->end_date;

        // 🧑 Update user name (optional: for display or log)
        if ($request->has('name')) {
            // This assumes there's a relationship: user()->update() or log the name separately
            $submission->user->name = $request->name;
            $submission->user->save();
        }

        // 📄 Handle file uploads
        if ($request->hasFile('paper')) {
            $submission->paper_path = $request->file('paper')->store('papers/conference', 'public');
        }

        if ($request->hasFile('department_rule_file')) {
            $submission->department_rule_path = $request->file('department_rule_file')->store('rules/department', 'public');
        }

        if ($request->hasFile('professor_rule_file')) {
            $submission->professor_rule_path = $request->file('professor_rule_file')->store('rules/professor', 'public');
        }

        // 💾 Save updates
        $submission->save();

        return redirect()->route('admin.papers.journals')->with('success', 'Journal submission updated successfully.');
    }
    public function destroy($id)
    {
        // 🔍 Find the submission
        $submission = JournalSubmission::findOrFail($id);

        // 🧹 Delete associated files if they exist
        if ($submission->paper_path && Storage::disk('public')->exists($submission->paper_path)) {
            Storage::disk('public')->delete($submission->paper_path);
        }

        if ($submission->department_rule_path && Storage::disk('public')->exists($submission->department_rule_path)) {
            Storage::disk('public')->delete($submission->department_rule_path);
        }

        if ($submission->professor_rule_path && Storage::disk('public')->exists($submission->professor_rule_path)) {
            Storage::disk('public')->delete($submission->professor_rule_path);
        }

        // 🗑 Delete the submission
        $submission->delete();

        // 🔁 Redirect back with success message
        return redirect()->route('admin.papers.journals')->with('success', 'Journal submission deleted successfully.');
    }

    public function downloadJournalPaper($id)
    {
        $schedule = JournalSubmission::findOrFail($id);
        $path = $schedule->paper_path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($path);
    }
    public function downloadJournalDpRule($id)
    {
        $schedule = JournalSubmission::findOrFail($id);
        $path = $schedule->department_rule_path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($path);
    }
    public function downloadJournalProRule($id)
    {
        $schedule = JournalSubmission::findOrFail($id);
        $path = $schedule->professor_rule_path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('public')->download($path);
    }

    public function returnJournal()
    {
        $reviews = \App\Models\JournalReview::with(['journalSubmission', 'reviewer1', 'reviewer2', 'reviewer3'])->get();


        return view('admin.reviewer.responsejournal', compact('reviews'));
    }
}