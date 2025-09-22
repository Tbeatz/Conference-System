<?php

namespace App\Http\Controllers;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $topics = Topic::all();
    return view('admin.topics.index', compact('topics'));
}

public function create()
{
    return view('admin.topics.create');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:topics,name|max:255'
        ]);

        Topic::create($request->only('name'));

        return redirect()->route('admin.topics.index')->with('success', 'Topic created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topic $topic)
    {
        return view('admin.topics.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topic $topic)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Update the topic with validated data
    $topic->update($validated);

    // Redirect back with success message
    return redirect()->route('admin.topics.index')
                     ->with('success', 'Topic updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
{
    $topic->delete();

    return redirect()->route('admin.topics.index')
                     ->with('success', 'Topic deleted successfully.');
}

}
