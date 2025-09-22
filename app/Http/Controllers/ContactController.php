<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    // Show all messages
    public function index()
    {
        $messages = ContactMessage::latest()->get(); // latest messages first
        return view('admin.contact.index', compact('messages'));
    }

    // Show only unread messages
    public function unread()
    {
        $messages = ContactMessage::where('status', 'unread')->latest()->get();
        return view('admin.contact.index', compact('messages'));
    }

    // Show only responded messages
    public function responded()
    {
        $messages = ContactMessage::where('status', 'responded')->latest()->get();
        return view('admin.contact.index', compact('messages'));
    }

    // Optional: mark message as read/responded
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['status' => 'responded']); // or 'read'
        return redirect()->back()->with('success', 'Message marked as responded.');
    }

    // Optional: show single message
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('admin.contact.show', compact('message'));
    }
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id); // Find or fail if not exist
        $message->delete(); // Delete the message

        return redirect()->route('admin.contact.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}
