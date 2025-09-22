<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JournalSubmission;
use App\Models\User;
use App\Models\ReviewSchedule;

class UserController extends Controller
{
    public function reviewer()
    {


        $reviewers = User::whereHas('roles', function ($query) {
            $query->where('name', 'reviewer');
        })->get();
        return view('admin.user.userlist', compact('reviewers'));
    }
    public function author()
    {


        $authors = User::whereHas('roles', function ($query) {
            $query->where('name', 'author');
        })->get();
        return view('admin.user.authorlist', compact('authors'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        // Return an edit view with user data
        return view('admin.user.edit', compact('user'));
    }
        public function editreviewer($id)
    {
        $user = User::findOrFail($id);
        // Return an edit view with user data
        return view('admin.user.editreviewer', compact('user'));
    }

    // Update user info
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            // 'address' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',

        ]);

        $user->update($validated);

        return redirect()->route('admin.user.author')->with('success', 'User updated successfully!');
    }
public function updatereviewer(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            // 'address' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',

        ]);

        $user->update($validated);

        return redirect()->route('admin.user.reviewer')->with('success', 'User updated successfully!');
    }
    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    // Your custom 'approach' action (modify as needed)
    public function approach($id)
    {
        $user = User::findOrFail($id);
        if ($user->email_verified_at != null) {
            $user->email_verified_at = null;
            $user->save();
            // For demonstration, just redirect back with success message
            return redirect()->back()->with('success', "DisApproached user {$user->name} successfully!");
        }
        // Perform some action, e.g., mark as approached or send notification
        // Example: $user->approached = true; $user->save();

        else {
            $user->email_verified_at = now();
            $user->save();
            // For demonstration, just redirect back with success message
            return redirect()->back()->with('success', "Approached user {$user->name} successfully!");
        }
    }
}
