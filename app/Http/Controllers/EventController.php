<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Category;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $events = Event::with('category', 'topics')->get();
    return view('admin.events.index', compact('events'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $topics = Topic::all(); // Get all topics
    $categories = Category::all();
    return view('admin.events.create', compact('topics', 'categories'));
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{

    $validated = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
        'location' => 'nullable|string',
        'publication_partner' => 'nullable|string',
        'submission_deadline' => 'nullable|date',
        'acceptance_date' => 'nullable|date',
        'camera_ready_deadline' => 'nullable|date',
        'event_website' => 'nullable|url',
        'organizer' => 'nullable|string',
        'contact_email' => 'nullable|email',
        'status' => 'required|in:upcoming,open,closed,published',
        'topics' => 'nullable|array',
        'topics.*' => 'exists:topics,id',
    ]);

    $event = Event::create($validated);

    // Attach topics directly
    $event->topics()->sync($validated['topics'] ?? []);

    return redirect()->route('admin.events.index')->with('success', 'Event created with topics.');
}



    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $event = Event::with(['category', 'topics'])->findOrFail($id);
    return view('admin.events.show', compact('event'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $categories = Category::all();
        $topics = Topic::all();
        $event->load('topics');
        return view('admin.events.edit', compact('event', 'categories', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'location' => 'nullable|string|max:255',
            'publication_partner' => 'nullable|string|max:255',
            'submission_deadline' => 'nullable|date',
            'acceptance_date' => 'nullable|date',
            'camera_ready_deadline' => 'nullable|date',
            'event_website' => 'nullable|url|max:255',
            'organizer' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'status' => 'required|in:upcoming,open,closed,published',
            'topics' => 'nullable|array',
            'topics.*' => 'exists:topics,id',
        ]);

        $event->update($validated);
        $event->topics()->sync($validated['topics'] ?? []);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->topics()->detach();
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
