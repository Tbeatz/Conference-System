<?php

namespace App\Http\Controllers\guest;

use App\Http\Controllers\Controller;
use App\Models\ReviewConferenceSchedule;
use App\Models\ReviewJournalSchedule;
use App\Models\JournalSubmission;
use App\Models\Keyword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Role;
use App\Models\Topic;
use App\Models\CommitteeMember;
use App\Models\Conference;
use App\Models\ConferenceSubmission;
use App\Models\Journal;
use App\Models\RegistrationInfo;
use Illuminate\Http\Request;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // Date
        $topics = Topic::all();
        $roles = Role::whereNotIn('name', ['admin'])->get();

        $allKeywords = Keyword::orderBy('name')->get();
        $userId = Auth::id();

        // Get topic_ids used in journal submissions
        $journalTopics = \App\Models\JournalSubmission::where('user_id', $userId)
            ->pluck('topic_id');

        // Get topic_ids used in conference submissions
        $conferenceTopics = \App\Models\ConferenceSubmission::where('user_id', $userId)
            ->pluck('topic_id');

        // Merge and get unique topic IDs used
        $usedTopics = $journalTopics->merge($conferenceTopics)->unique()->toArray();

        // Exclude those topics
        $topics = \App\Models\Topic::whereNotIn('id', $usedTopics)->get();



        $currentDate = Carbon::now()->isoFormat('dddd, Do MMMM, YYYY'); // Example: Friday, 12th July, 2025

        // Weather from OpenWeatherMap



        // Get conferences with status 'open' and end_date >= today
        $conferences = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('events.status', 'published')
            // ->whereDate('events.submission_deadline', '>=', Carbon::today())
            ->where('categories.name', 'conference')
            ->orderByDesc('events.created_at')
            ->select('events.*') // Or include category data if needed
            ->get();

        foreach ($conferences as $conference) {
            $conference->latest_submission = DB::table('conference_submissions')
                ->where('event_id', $conference->id)
                ->latest('created_at')
                ->first(); // single submission
        }






        // Get journals with status 'published' and end_date >= today
        $journals = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->where('events.status', 'published')
            // ->whereDate('events.submission_deadline', '>=', Carbon::today())
            ->where('categories.name', 'journal')
            ->orderByDesc('events.created_at')
            ->select('events.*') // Or include category data if needed
            ->get();


        $user = Auth::user();

        // Optionally eager load unread notifications or paginate
        $notifications = collect(); // default empty collection

        if ($user) {
            $notifications = $user->unreadNotifications->sortByDesc('created_at');
        }


        $today = Carbon::today();
        $conferencesubmissions = collect(); // default empty collection
        $journalsubmissions = collect();
        if ($user) {
            $conferencesubmissions = ReviewConferenceSchedule::where(function ($query) use ($user) {
                $query->whereHas('conferenceSubmission', function ($subQuery) use ($user) {
                    $subQuery->where('user_id', $user->id);
                })
                    ->orWhere(function ($orQuery) use ($user) {
                        $orQuery->where('reviewer1_id', $user->id)
                            ->orWhere('reviewer2_id', $user->id)
                            ->orWhere('reviewer3_id', $user->id);
                    });
            })
                ->where('status', 'send')
                ->whereHas('conferenceSubmission.event', function ($q) use ($today) {
                    $q->whereDate('submission_deadline', '<', $today);
                })
                ->with(['conferenceSubmission.event']) // eager load event if needed
                ->get();

            $journalsubmissions = ReviewJournalSchedule::where(function ($query) use ($user) {
                $query->whereHas('journalSubmission', function ($subQuery) use ($user) {
                    $subQuery->where('user_id', $user->id);
                })
                    ->orWhere(function ($orQuery) use ($user) {
                        $orQuery->where('reviewer1_id', $user->id)
                            ->orWhere('reviewer2_id', $user->id)
                            ->orWhere('reviewer3_id', $user->id);
                    });
            })
                ->where('status', 'send')
                ->whereHas('journalSubmission.event', function ($q) use ($today) {
                    $q->whereDate('submission_deadline', '<', $today);
                })
                ->with(['journalSubmission.event']) // optional eager loading
                ->get();
        }
        $journal = Journal::where('status', 'published')->get();
        $conferenceresult = Conference::where('status', 'published')
            ->distinct() // ensures unique conferences
            ->with(['topic', 'category'])
            ->get();

        $events = Event::whereYear('created_at', now()->year)->first();


        $infos = RegistrationInfo::all()->groupBy('type');
        return view('guest.dashboard', compact('infos', 'currentDate', 'conferences', 'conferenceresult', 'journals', 'journal', 'conference', 'topics', 'allKeywords', 'roles',  'conferencesubmissions', 'journalsubmissions', 'topics', 'notifications', 'events'), [
            'generalChair' => CommitteeMember::where('role', 'General Chair')->first(),
            'programChair' => CommitteeMember::where('role', 'Program Chair')->first(),
            'members' => CommitteeMember::where('role', 'Member')->orderBy('name')->get(),
        ]);
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $results = collect();
        if ($query) {
            $results = \App\Models\ConferenceSubmission::where('keywords', 'like', "%{$query}%")

                ->get();
        }

        if ($request->ajax()) {
            if ($request->ajax()) {
                return view('admin.search-results', compact('results', 'query'))->render();
            }
        }


        return redirect()->back()->with('results', 'query');
    }
}