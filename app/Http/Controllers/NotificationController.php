<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\ConferenceSubmission;

class NotificationController extends Controller
{


    public function markRead($id)
    {
        $notification = DatabaseNotification::where('id', $id)
            ->where('notifiable_id', Auth::id())
            ->first();

        if (!$notification) {
            return back()->with('error', 'Notification not found.');
        }

        $notification->markAsRead();
        if (isset($notification->data['submission_id'])) {
            $submission = ConferenceSubmission::find($notification->data['submission_id']);
            if ($submission) {
                $submission->kpay_status = 'under_review';
                $submission->save();
            }
        }

        return back()->with('success', 'Notification marked as read.');
    }
}
