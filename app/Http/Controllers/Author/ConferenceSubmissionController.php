<?php

namespace App\Http\Controllers\Author;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ConferenceSubmission;
use App\Models\ConferenceReview;
use App\Models\Category;
use App\Notifications\ReviewDecisionNotification;
use Illuminate\Support\Facades\DB;

class ConferenceSubmissionController extends Controller
{
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'topic_id' => 'required|integer|exists:topics,id',
    //         'abstract' => 'required|string',
    //         'keywords' => 'required|string',
    //         'paper' => 'required|file',
    //         'department_rule_file' => 'required|file',
    //         'professor_rule_file' => 'required|file',
    //         'event_id' => 'required|integer'
    //     ]);
    //     $validated['user_id'] = Auth::id();
    //     $authorCategory = Category::where('name', 'conference')->first();
    //     $validated['category_id'] =  $authorCategory->id;

    //       // Paper upload
    // if ($request->hasFile('paper')) {
    //     $file = $request->file('paper');
    //     $originalName = $file->getClientOriginalName(); // original file name
    //     $fileName = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $file->getClientOriginalExtension();

    //     $validated['paper_original_name'] = $originalName; // <-- save original file name
    //     $validated['paper_path'] = $file->storeAs('conferences/papers', $fileName, 'public');
    // }

    //     if ($request->hasFile('department_rule_file')) {
    //         $file = $request->file('department_rule_file');
    //         $fileName = $file->getClientOriginalName().'_'.time();;
    //         $validated['department_rule_path'] = $file->storeAs('conferences/dept_rules', $fileName, 'public');
    //     }

    //     if ($request->hasFile('professor_rule_file')) {
    //         $file = $request->file('professor_rule_file');
    //         $fileName = $file->getClientOriginalName().'_'.time();;
    //         $validated['professor_rule_path'] = $file->storeAs('conferences/prof_rules', $fileName, 'public');
    //     }

    //     // Save new conference record
    //     ConferenceSubmission::create($validated);

    //     return redirect()->back()->with('success', 'Conference submitted successfully!');
    // }
    // version 1
    //     public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'topic_id' => 'required|integer|exists:topics,id',
    //         'abstract' => 'required|string',
    //         'keywords' => 'required|string',
    //         'paper' => 'required|file',
    //         'department_rule_file' => 'required|file',
    //         'professor_rule_file' => 'required|file',
    //         'event_id' => 'required|integer',
    //     ]);

    //     // Set user and category
    //     $validated['user_id'] = Auth::id();
    //     $authorCategory = Category::where('name', 'conference')->first();
    //     $validated['category_id'] = $authorCategory?->id;

    //     // -------- Paper Upload --------
    //     if ($request->hasFile('paper')) {
    //         $file = $request->file('paper');
    //         $originalName = $file->getClientOriginalName();

    //         $validated['paper_original_name'] = $originalName;
    //         $validated['paper_path'] = $file->storeAs('conferences/papers', $originalName, 'public');
    //     }

    //     // -------- Department Rule File Upload --------
    //     if ($request->hasFile('department_rule_file')) {
    //         $deptfile = $request->file('department_rule_file');
    //         $deptoriginalName = $deptfile->getClientOriginalName();

    //         // $validated['department_rule_original_name'] = $originalName;
    //         $validated['department_rule_path'] = $deptfile->storeAs('conferences/dept_rules', $deptoriginalName, 'public');
    //     }

    //     // -------- Professor Rule File Upload --------
    //     if ($request->hasFile('professor_rule_file')) {
    //         $professorfile = $request->file('professor_rule_file');
    //         $professororiginalName = $professorfile->getClientOriginalName();

    //         // $validated['professor_rule_original_name'] = $originalName;
    //         $validated['professor_rule_path'] = $professorfile->storeAs('conferences/prof_rules', $professororiginalName, 'public');
    //     }

    //     // Save record
    //     ConferenceSubmission::create($validated);

    //     return redirect()->back()->with('success', 'Conference submitted successfully!');
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic_id' => 'required|integer|exists:topics,id',
            'abstract' => 'required|string',
            'keywords' => 'required|string',
            'paper' => 'required|file',
            'department_rule_file' => 'required|file',
            'professor_rule_file' => 'required|file',
            'event_id' => 'required|integer',
        ]);

        $validated['user_id'] = Auth::id();
        $authorCategory = Category::where('name', 'conference')->first();
        $validated['category_id'] = $authorCategory?->id;

        // -------- Paper Upload --------
        if ($request->hasFile('paper')) {
            $file = $request->file('paper');
            $originalName = $file->getClientOriginalName();
            $validated['paper_original_name'] = $originalName;
            $validated['paper_path'] = $file->storeAs('conferences/papers', $originalName, 'public');
        }

        // -------- Department Rule File Upload --------
        if ($request->hasFile('department_rule_file')) {
            $deptfile = $request->file('department_rule_file');
            $deptoriginalName = $deptfile->getClientOriginalName();
            $validated['department_rule_path'] = $deptfile->storeAs('conferences/dept_rules', $deptoriginalName, 'public');
        }

        // -------- Professor Rule File Upload --------
        if ($request->hasFile('professor_rule_file')) {
            $professorfile = $request->file('professor_rule_file');
            $professororiginalName = $professorfile->getClientOriginalName();
            $validated['professor_rule_path'] = $professorfile->storeAs('conferences/prof_rules', $professororiginalName, 'public');
            $validated['kpay_status'] = 'submitted';
        }

        // -------- KPay Image Upload --------
        // -------- KPay Image Upload --------
        // if ($request->hasFile('kpay_image')) {
        //     $kpayFile = $request->file('kpay_image');
        //     $kpayOriginalName = $kpayFile->getClientOriginalName();

        //     $validated['kpay_image_path'] = $kpayFile->storeAs('conferences/kpay', $kpayOriginalName, 'public');
        //     // ✅ default pending
        // }


        // Save record
        ConferenceSubmission::create($validated);

        return redirect()->back()->with('success', 'Conference submitted successfully!');
    }


    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'topic_id' => 'required|integer|exists:topics,id',
    //         'abstract' => 'required|string',
    //         'keywords' => 'required|string',
    //         'paper' => 'required|file',
    //         'department_approval_letter' => 'required|file',
    //         'recommendation_letter' => 'required|file',
    //         'event_id' => 'required|integer',
    //     ]);

    //     $validated['user_id'] = Auth::id();
    //     $authorCategory = Category::where('name', 'conference')->first();
    //     $validated['category_id'] = $authorCategory?->id;

    //     // -------- Paper Upload --------
    //     if ($request->hasFile('paper')) {
    //         $file = $request->file('paper');
    //         $originalName = $file->getClientOriginalName();

    //         $file->storeAs('conferences/papers', $originalName, 'public');

    //         $validated['paper_path'] = $originalName;           // Paper filename
    //         $validated['paper_original_name'] = $originalName;  // Same as paper_path
    //     }

    //     // -------- Department Approval Letter --------
    //     if ($request->hasFile('department_rule_file')) {
    //         $file = $request->file('department_rule_file');
    //         $originalName = $file->getClientOriginalName();

    //         $file->storeAs('conferences/dept_letters', $originalName, 'public');

    //         $validated['department_rule_path'] = $originalName; // Dept filename
    //     }

    //     // -------- University Recommendation Letter --------
    //     if ($request->hasFile('professor_rule_file')) {
    //         $file = $request->file('professor_rule_file');
    //         $originalName = $file->getClientOriginalName();

    //         $file->storeAs('conferences/recommendations', $originalName, 'public');

    //         $validated['professor_rule_path'] = $originalName; // Recommendation filename
    //     }

    //     ConferenceSubmission::create($validated);

    //     return redirect()->back()->with('success', 'Conference submitted successfully!');
    // }


    // public function update(Request $request, $id)
    // {
    //     // Find submission or fail
    //     $submission = ConferenceSubmission::findOrFail($id);

    //     // Validation rules
    //     $rules = [

    //         'abstract' => 'required|string',
    //         'keywords' => 'required|string',
    //         'paper' => 'nullable|file', // max 10MB
    //         'department_rule_file' => 'nullable|file',
    //         'professor_rule_file' => 'nullable|file',
    //     ];

    //     $validated = $request->validate($rules);
    //     // Track related review row (assumes 1:1 relation for simplicity)
    //     $review = ConferenceReview::where('conference_submission_id', $id)->first();
    //     // adjust if relationship is different

    //     if ($submission->edit_count >= 3) {
    //         $review->evaluation = 'reject';
    //     }

    //     $review->save();

    //     $submission->edit_count += 1;

    //     // Update basic fields

    //     $submission->abstract = $validated['abstract'];
    //     $submission->keywords = $validated['keywords'];

    //     // Handle file uploads
    //     if ($request->hasFile('paper')) {
    //         // Delete old paper if exists
    //         if ($submission->paper_path && Storage::disk('public')->exists($submission->paper_path)) {
    //             Storage::disk('public')->delete($submission->paper_path);
    //         }
    //         $paperPath = $request->file('paper')->store('conferences/papers', 'public');
    //         $submission->paper_path = $paperPath;
    //     }

    //     if ($request->hasFile('department_rule_file')) {
    //         if ($submission->department_rule_path && Storage::disk('public')->exists($submission->department_rule_path)) {
    //             Storage::disk('public')->delete($submission->department_rule_path);
    //         }
    //         $deptRulePath = $request->file('department_rule_file')->store('conferences/dept_rules', 'public');
    //         $submission->department_rule_path = $deptRulePath;
    //     }

    //     if ($request->hasFile('professor_rule_file')) {
    //         if ($submission->professor_rule_path && Storage::disk('public')->exists($submission->professor_rule_path)) {
    //             Storage::disk('public')->delete($submission->professor_rule_path);
    //         }
    //         $profRulePath = $request->file('professor_rule_file')->store('conferences/prof_rules', 'public');
    //         $submission->professor_rule_path = $profRulePath;
    //     }

    //     $submission->save();
    //     if ($submission && ($author = $submission->author)) {
    //         // Prepare notification data
    //         $notificationData = (new ReviewDecisionNotification($submission, $review))->toDatabase($author);

    //         // Try to find an existing notification for this submission + type
    //         $existing = DB::table('notifications')
    //             ->where('notifiable_id', $author->id)
    //             ->where('notifiable_type', get_class($author))
    //             ->where('type', ReviewDecisionNotification::class)
    //             ->where('data->submission_id', $submission->id)
    //             ->first();

    //         if ($existing) {
    //             // Update the existing notification
    //             DB::table('notifications')->where('id', $existing->id)->update([
    //                 'data' => json_encode($notificationData),
    //                 'updated_at' => now(),
    //                 'read_at' => null // Optionally reset read status
    //             ]);
    //         } else {
    //             // Create a new notification
    //             DB::table('notifications')->insert([
    //                 'id' => Str::uuid()->toString(),
    //                 'type' => ReviewDecisionNotification::class,
    //                 'notifiable_type' => get_class($author),
    //                 'notifiable_id' => $author->id,
    //                 'data' => json_encode($notificationData),
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]);
    //         }
    //     }

    //     return redirect()->back()
    //         ->with('success', 'Conference submission updated successfully.');
    // }

    public function update(Request $request, $id)
    {
        $submission = ConferenceSubmission::findOrFail($id);

        // Validation
        $validated = $request->validate([
            'abstract' => 'nullable|string',
            'keywords' => 'nullable|string',
            'paper' => 'nullable|file',
            'department_rule_file' => 'nullable|file',
            'professor_rule_file' => 'nullable|file',
            'kpay_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // ✅ Added
        ]);

        // Abstract + Keywords
        if (isset($validated['abstract'])) {
            $submission->abstract = $validated['abstract'];
        }
        if (isset($validated['keywords'])) {
            $submission->keywords = $validated['keywords'];
        }

        // -------- Paper Upload --------
        if ($request->hasFile('paper')) {
            if ($submission->paper_path && Storage::disk('public')->exists($submission->paper_path)) {
                Storage::disk('public')->delete($submission->paper_path);
            }
            $file = $request->file('paper');
            $originalName = $file->getClientOriginalName();

            $submission->paper_original_name = $originalName;
            $submission->paper_path = $file->storeAs('conferences/papers', $originalName, 'public');
        }

        // -------- Department Rule File Upload --------
        if ($request->hasFile('department_rule_file')) {
            if ($submission->department_rule_path && Storage::disk('public')->exists($submission->department_rule_path)) {
                Storage::disk('public')->delete($submission->department_rule_path);
            }
            $file = $request->file('department_rule_file');
            $originalName = $file->getClientOriginalName();

            $submission->department_rule_path = $file->storeAs('conferences/dept_rules', $originalName, 'public');
        }

        // -------- Professor Rule File Upload --------
        if ($request->hasFile('professor_rule_file')) {
            if ($submission->professor_rule_path && Storage::disk('public')->exists($submission->professor_rule_path)) {
                Storage::disk('public')->delete($submission->professor_rule_path);
            }
            $file = $request->file('professor_rule_file');
            $originalName = $file->getClientOriginalName();

            $submission->professor_rule_path = $file->storeAs('conferences/prof_rules', $originalName, 'public');
        }

        // -------- KPay Image Upload -------- ✅
        if ($request->hasFile('kpay_image')) {
            $path = $request->file('kpay_image')->store('kpay_images', 'public');
            $submission->kpay_image_path = $path;
        }

        $submission->save();

        return back()->with('success', 'Conference submission updated successfully.');
    }
}
