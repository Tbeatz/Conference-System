<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ConferenceSubmission;
use App\Models\Keyword;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\JournalSubmission;
use Illuminate\Support\Facades\DB;


class ConferenceManagementController extends Controller
{


    public function index()
    {
        // Author count
        $authorCount = DB::table('role_user')->where('role_id', 3)->count(); // assume role_id 1 = Author

        // Reviewer count
        $reviewerCount = DB::table('role_user')->where('role_id', 2)->count(); // assume role_id 2 = Reviewer

        // Paper count
        $paperCount = ConferenceSubmission::count();

        // Total users
        $totalUsers = User::count();

        // User distribution by role for pipe chart
        $roleDistribution = DB::table('roles')
            ->leftJoin('role_user', 'roles.id', '=', 'role_user.role_id')
            ->select('roles.name', DB::raw('COUNT(role_user.user_id) as count'))
            ->groupBy('roles.id', 'roles.name')
            ->get()
            ->unique('name'); // ensures unique role name

        $unverifiedAuthors = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.name', 'Reviewer')
            ->whereNull('users.email_verified_at')
            ->select('users.id', 'users.name', 'users.email')
            ->get();

        $paperCounts = ConferenceSubmission::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.dashboard', compact('paperCounts', 'authorCount', 'reviewerCount', 'paperCount', 'totalUsers', 'roleDistribution', 'unverifiedAuthors'));
    }

    public function conferences()
    {
        $user = Auth::user(); // assuming only their own submissions


        // $conferenceSubmissions = ConferenceSubmission::latest()->get();
        // $conferenceSubmissions = ConferenceSubmission::orderBy('updated_at', 'desc')->get();

        $conferenceSubmissions = ConferenceSubmission::orderBy('updated_at', 'desc')->get();

        return view('admin.authorpapers.conferences', compact('conferenceSubmissions'));
    }
    public function edit($id)
    {
        $topics = Topic::all();
        $categories = Category::all();
        $allKeywords = Keyword::orderBy('name')->get();
        $submission = ConferenceSubmission::find($id);

        return view('admin.authorpapers.conferencesedit', compact(
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
        $submission = ConferenceSubmission::findOrFail($id);

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
            // $submission->paper_path = $request->file('paper')->store('papers/conference', 'public');
            // $submission->paper_path = $request->file('paper')->getClientOriginalName();
            // Store the file
            $submission->paper_path = $request->file('paper')->store('papers/conference', 'public');

            // Save original file name
            $submission->paper_original_name = $request->file('paper')->getClientOriginalName();
        }

        if ($request->hasFile('department_rule_file')) {
            $submission->department_rule_path = $request->file('department_rule_file')->store('rules/department', 'public');
            $submission->paper_original_name = $request->file('department_rule_file')->getClientOriginalName();
        }

        if ($request->hasFile('professor_rule_file')) {
            $submission->professor_rule_path = $request->file('professor_rule_file')->store('rules/professor', 'public');
            $submission->paper_original_name = $request->file('professor_rule_file')->getClientOriginalName();
        }
        //         if ($request->hasFile('professor_rule_file')) {
        //     $submission->professor_rule_path = $request->file('professor_rule_file')->store('rules/professor', 'public');
        //     $submission->paper_original_name = $request->file('professor_rule_file')->getClientOriginalName();
        // }


        // 💾 Save updates
        $submission->save();

        return redirect()->route('admin.papers.conferences')->with('success', 'Conference submission updated successfully.');
    }


    public function destroy($id)
    {
        // 🔍 Find the submission
        $submission = ConferenceSubmission::findOrFail($id);

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
        return redirect()->route('admin.papers.conferences')->with('success', 'Conference submission deleted successfully.');
    }

    public function downloadConferencePaper($id)
    {
        $submission = ConferenceSubmission::findOrFail($id);
        $path = $submission->paper_path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }

        // Use original file name if available, otherwise use stored filename
        $originalName = $submission->paper_original_name ?? basename($path);

        return Storage::disk('public')->download($path, $originalName);
    }

    public function viewConferencePaper($id)
    {
        $submission = ConferenceSubmission::findOrFail($id);
        $path = $submission->paper_path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }

        // file contents ကို browser ထဲမှာ inline ဖွင့်မယ်
        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);

        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header(
                'Content-Disposition',
                'inline; filename="' . ($submission->paper_original_name ?? basename($path)) . '"'
            );
    }

    public function downloadConferenceDpRule($id)
    {
        $schedule = ConferenceSubmission::findOrFail($id);
        $path = $schedule->department_rule_path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }

        $originalName = $submission->paper_original_name ?? basename($path);
        // return Storage::disk('public')->download($path);
        // return Storage::disk('public')->download($path, $schedule->paper_original_name);
        return Storage::disk('public')->download($path, $originalName);
    }
    public function downloadConferenceProRule($id)
    {
        $schedule = ConferenceSubmission::findOrFail($id);
        $path = $schedule->professor_rule_path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File not found.');
        }

        $originalName = $submission->paper_original_name ?? basename($path);
        // return Storage::disk('public')->download($path);
        // return Storage::disk('public')->download($path, $schedule->paper_original_name);
        return Storage::disk('public')->download($path, $originalName);
    }
    public function returnConference()
    {
        $reviews = \App\Models\ConferenceReview::with([
            'conferenceSubmission' => function ($query) {
                $query->select('id', 'event_id', 'user_id', 'kpay_image_path', 'kpay_status'); // ✅ include kpay fields
            },
            'reviewer1',
            'reviewer2',
            'reviewer3'
        ])->get();

        return view('admin.reviewer.responseConference', compact('reviews'));
    }
}
