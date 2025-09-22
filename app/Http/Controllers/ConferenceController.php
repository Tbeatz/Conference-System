<?php


namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use PhpOffice\PhpWord\Settings as WordSettings;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::all();
        return view('admin.conferences.index', compact('conferences'));
    }

    public function create()
    {
        $categories = DB::table('categories')
            ->where('categories.name', 'conference')
            ->get();
        $topics = Topic::all();

        return view('admin.conferences.create', compact('categories', 'topics'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'topic_id' => 'required|exists:topics,id',
            'description' => 'nullable|string',
            'papers' => 'required|array|min:1',
            'papers.*' => 'file|mimes:pdf,doc,docx|max:10240',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
             'publication_date' => 'nullable|date',
            'contact_email' => 'nullable|email',
            'status' => 'required|in:open,reviewing,accepted,published,closed',
        ]);

        $mergedFileName = null;

        DB::beginTransaction();
        try {
            if ($request->hasFile('papers')) {
                $pdf = new Fpdi();
                $tempPaths = [];

                foreach ($request->file('papers') as $file) {
                    $tempPath = $file->store('temp_pdfs');
                    $fullPath = storage_path('app/' . $tempPath);
                    $extension = strtolower($file->getClientOriginalExtension());

                    // 🔹 Convert DOC/DOCX to PDF
                    if (in_array($extension, ['doc', 'docx'])) {
                        WordSettings::setPdfRendererName('DomPDF');
                        WordSettings::setPdfRendererPath(base_path('vendor/dompdf/dompdf'));

                        $phpWord = WordIOFactory::load($fullPath);
                        $pdfWriter = WordIOFactory::createWriter($phpWord, 'PDF');

                        $convertedPath = $fullPath . '.pdf';
                        $pdfWriter->save($convertedPath);

                        $fullPath = $convertedPath;
                    }

                    $tempPaths[] = $fullPath;

                    // 🔹 Merge PDF pages
                    $pageCount = $pdf->setSourceFile($fullPath);
                    for ($i = 1; $i <= $pageCount; $i++) {
                        $template = $pdf->importPage($i);
                        $size = $pdf->getTemplateSize($template);
                        $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                        $pdf->useTemplate($template);
                    }
                }

                // 🔹 Save merged PDF in public storage
                $mergedFileName = 'papers/merged_' . uniqid() . '_' . time() . '.pdf';
                $mergedPath = storage_path('app/public/' . $mergedFileName);
                $pdf->Output($mergedPath, 'F');

                // 🔹 Delete temp files
                foreach ($tempPaths as $path) {
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }

            Conference::create([
                'category_id' => $validated['category_id'],
                'topic_id' => $validated['topic_id'],
                'description' => $validated['description'] ?? null,
                'paper_path' => $mergedFileName,
                'start_date' => $validated['start_date'] ?? null,
                'end_date' => $validated['end_date'] ?? null,
                'publication_date' => $validated['publication_date'] ?? null,
                'contact_email' => $validated['contact_email'] ?? null,
                'status' => $validated['status'],
                'reviewer_id' => null,
                'author_id' => Auth::id(),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'File merge failed: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.conferences.index')->with('success', 'Conference created and papers merged.');
    }



    public function edit(Conference $conference)
    {
        $categories = Category::all();
        $topics = Topic::all();

        return view('admin.conferences.edit', compact('conference', 'categories', 'topics'));
    }

    public function update(Request $request, Conference $conference)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'topic_id' => 'required|exists:topics,id',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
             'publication_date' => 'nullable|date',
            // 'conference_website' => 'nullable|url',
            'contact_email' => 'nullable|email',
            'status' => 'required|in:open,reviewing,accepted,published,closed',
        ]);

        $conference->update($validated);

        return redirect()->route('admin.conferences.index')->with('success', 'Conference updated successfully.');
    }

    public function destroy(Conference $conference)
    {
        if ($conference->paper_path && Storage::disk('public')->exists($conference->paper_path)) {
            Storage::disk('public')->delete($conference->paper_path);
        }

        $conference->delete();

        return redirect()->route('admin.conferences.index')->with('success', 'Conference deleted successfully.');
    }
}
