<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommitteeMember;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function index()
    {
        $members = CommitteeMember::all();
        return view('admin.committee.index', compact('members'));
    }

    public function create()
    {
        return view('admin.committee.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:general_chair,program_chair,member',
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'affiliation' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        CommitteeMember::create($validated);

        return redirect()->route('admin.committee.index')->with('success', 'Committee member added.');
    }

    public function edit($id)
    {
        $member = CommitteeMember::findOrFail($id);
        return view('admin.committee.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required|in:general_chair,program_chair,member',
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'affiliation' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);
    //     $validated = $request->validate([
    // 'position' => 'required|in:general_chair,program_chair,member',
    // 'title' => 'required|string|max:255',
    // 'name' => 'required|string|max:255',
    // 'affiliation' => 'required|string|max:255',
    // 'country' => 'nullable|string|max:255',
// ]);

        $member = CommitteeMember::findOrFail($id);
        $member->update($validated);

        return redirect()->route('admin.committee.index')->with('success', 'Committee member updated.');
    }

    public function destroy($id)
    {
        $member = CommitteeMember::findOrFail($id);
        $member->delete();

        return redirect()->route('admin.committee.index')->with('success', 'Committee member deleted.');
    }
}
