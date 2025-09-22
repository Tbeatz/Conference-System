<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    public function index()
    {

        $journals = Journal::all();
        return view('admin.journals.index', compact('journals'));
    }

    public function create()
    {
        $categories = DB::table('categories')
            ->where('categories.name', 'journal')
            ->get();
        $topics = Topic::all();

        return view('admin.journals.create', compact('categories', 'topics'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'topic_id' => 'required|exists:topics,id',
            'description' => 'nullable|string',
            'papers.*' => 'nullable|mimes:pdf|max:10240', // 10MB per file
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'publication_date' => 'nullable|date',
            'journal_website' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'status' => 'required|in:open,reviewing,accepted,published,closed',
        ]);

        $mergedFileName = null;

        if ($request->hasFile('papers')) {
            $pdf = new Fpdi();
            $tempPaths = [];

            foreach ($request->file('papers') as $file) {
                $tempPath = $file->store('temp_pdfs');
                $fullPath = storage_path('app/' . $tempPath);
                $tempPaths[] = $fullPath;

                $pageCount = $pdf->setSourceFile($fullPath);
                for ($i = 1; $i <= $pageCount; $i++) {
                    $template = $pdf->importPage($i);
                    $size = $pdf->getTemplateSize($template);
                    $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                    $pdf->useTemplate($template);
                }
            }

            $mergedFileName = 'papers/merged_' . Str::random(10) . '_' . Carbon::now()->timestamp . '.pdf';
            $mergedPath = storage_path('app/public/' . $mergedFileName);
            $pdf->Output($mergedPath, 'F');

            // Clean up temp files
            foreach ($tempPaths as $path) {
                if (file_exists($path)) {
                    unlink($path);
                }
            }
        }

        // Save Journal
        $journal = Journal::create([
            'category_id' => $validated['category_id'],
            'topic_id' => $validated['topic_id'],
            'description' => $validated['description'],
            'paper_path' => $mergedFileName, // saved relative to storage/app/public
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'publication_date' => $validated['publication_date'] ?? null,
            'journal_website' => $validated['journal_website'] ?? null,
            'contact_email' => $validated['contact_email'] ?? null,
            'status' => $validated['status'],
            'reviewer_id' => null,
            'author_id' => Auth::id(), // assuming the current user is the author
        ]);

        return redirect()->route('admin.journals.index')->with('success', 'Journal created and papers merged.');
    }
    public function edit(Journal $journal)
    {
        $categories = Category::all();
        $topics = Topic::all();

        return view('admin.journals.edit', compact('journal', 'categories', 'topics'));
    }
    public function update(Request $request, Journal $journal)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'topic_id' => 'required|exists:topics,id',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'publication_date' => 'nullable|date',
            'journal_website' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'status' => 'required|in:open,reviewing,accepted,published,closed',
        ]);

        $journal->update($validated);

        return redirect()->route('admin.journals.index')->with('success', 'Journal updated successfully.');
    }
    public function destroy(Journal $journal)
    {
        // Delete merged file if exists
        if ($journal->paper_path && Storage::disk('public')->exists($journal->paper_path)) {
            Storage::disk('public')->delete($journal->paper_path);
        }

        $journal->delete();

        return redirect()->route('admin.journals.index')->with('success', 'Journal deleted successfully.');
    }
}
