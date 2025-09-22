<?php

use App\Http\Controllers\Admin\JournalManagementController;
use App\Http\Controllers\Admin\ConferenceManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\guest\HomeController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Author\ConferenceSubmissionController;
use App\Http\Controllers\Author\JournalSubmissionController;
use App\Http\Controllers\Reviewer\ReviewerResponseController;
use App\Http\Controllers\Admin\ReviewJournalScheduleController;
use App\Http\Controllers\Admin\ReviewConferenceScheduleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RegistrationInfoController;
use App\Http\Controllers\Admin\CommitteeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\ConferenceController;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\NotificationController;
use App\Models\Journal;
use App\Http\Controllers\ContactController;

# Guest user routes
Route::get('/', [HomeController::class, 'index'])->name('guest.home');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);
    ContactMessage::create($validated);
    return back()->with('success', 'Your message has been sent successfully!');
})->name('contact.submit');

# Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/conference/submit', [ConferenceSubmissionController::class, 'store'])->name('conference.submit');
    Route::put('/conference/update/{id}', [ReviewerResponseController::class, 'updateConference'])->name('conference.update');
    Route::put('/conference/{id}', [ConferenceSubmissionController::class, 'update'])->name('conferences.update');

    Route::put('/journal/update/{id}', [ReviewerResponseController::class, 'updateJournal'])->name('journals.update');
    Route::post('/journal/submit', [JournalSubmissionController::class, 'store'])->name('journal.submit');
    Route::put('/journal/{id}', [JournalSubmissionController::class, 'update'])->name('journal.update');

    Route::get('/dashboard', [ConferenceManagementController::class, 'index'])->name('dashboard');
    Route::get('/conference/download/{id}', [ReviewerResponseController::class, 'downloadConferenceReviewPaper'])->name('conference.download');
    Route::get('/journal/download/{id}', [ReviewerResponseController::class, 'downloadJournalReviewPaper'])->name('journal.download');

    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
    Route::post('/notifications/{id}/mark-read-read', [NotificationController::class, 'markReadRead'])->name('notifications.markReadRead');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

# Topic routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('topics', TopicController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

# Event routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('events', EventController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
});

Route::get('/conference-search', [HomeController::class, 'search'])->name('conference.search');

# Author Papers
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('papers/journals', [JournalManagementController::class, 'journals'])->name('papers.journals');
    Route::get('papers/journals/paper/download/{id}', [JournalManagementController::class, 'downloadJournalPaper'])->name('journalpaper.download');
    Route::get('papers/journals/dprule/download/{id}', [JournalManagementController::class, 'downloadJournalDpRule'])->name('journaldprule.download');
    Route::get('papers/journals/prorule/download/{id}', [JournalManagementController::class, 'downloadJournalReview'])->name('journalprorule.download');
    Route::get('papers/journals/edit/{id}', [JournalManagementController::class, 'edit'])->name('papers.journalsedit');
    Route::put('papers/journals/update/{id}', [JournalManagementController::class, 'update'])->name('papers.journalupdate');
    Route::delete('papers/journals/delete/{id}', [JournalManagementController::class, 'destroy'])->name('papers.journalsdestroy');

    Route::get('papers/conferences', [ConferenceManagementController::class, 'conferences'])->name('papers.conferences');
    Route::get('papers/conferences/paper/download/{id}', [ConferenceManagementController::class, 'downloadConferencePaper'])->name('conferencepaper.download');
    Route::get('papers/conferences/dprule/download/{id}', [ConferenceManagementController::class, 'downloadConferenceDpRule'])->name('conferencedprule.download');
    // Route::get('papers/conferences/prorule/download/{id}', [ConferenceManagementController::class, 'downloadConferenceReview'])->name('conferenceprorule.download');
    Route::get(
        'papers/conferences/prorule/download/{id}',
        [ConferenceManagementController::class, 'downloadConferenceProRule']
    )->name('conferenceprorule.download');
    Route::get('papers/conferences/edit/{id}', [ConferenceManagementController::class, 'edit'])->name('papers.conferencesedit');
    Route::put('papers/conferences/update/{id}', [ConferenceManagementController::class, 'update'])->name('papers.conferenceupdate');
    Route::delete('papers/conferences/delete/{id}', [ConferenceManagementController::class, 'destroy'])->name('papers.conferencesdestroy');
    Route::get('conference/download/{id}', [ConferenceManagementController::class, 'downloadConferencePaper'])->name('conference.download');
});

# Review Schedule routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    # Journal
    Route::get('schedule/journal', [ReviewJournalScheduleController::class, 'journalschedule'])->name('schedule.journal');
    Route::get('schedule/conference', [ReviewConferenceScheduleController::class, 'conferenceschedule'])->name('schedule.conference');
    Route::post('schedule/journal/store', [ReviewJournalScheduleController::class, 'store'])->name('schedule.journalstore');
    Route::get('schedule/journal/view', [ReviewJournalScheduleController::class, 'viewjournalschedule'])->name('schedule.journalview');
    Route::delete('schedule/journal/destroy/{id}', [ReviewJournalScheduleController::class, 'destroy'])->name('schedule.journaldestroy');
    Route::get('schedule/journal/edit/{id}', [ReviewJournalScheduleController::class, 'edit'])->name('schedule.journaledit');
    Route::put('schedule/journal/update/{id}', [ReviewJournalScheduleController::class, 'update'])->name('schedule.journalupdate');
    Route::put('schedule/journal/send/{id}', [ReviewJournalScheduleController::class, 'upload'])->name('schedule.journalsend');
    Route::get('papers/journals/return', [JournalManagementController::class, 'returnJournal'])->name('schedule.journalreview');
    Route::delete('papers/journal-reviews/destroy/{id}', [ReviewJournalScheduleController::class, 'destroyReturnJournal'])->name('schedule.journalreturndestroy');
    Route::put('papers/journal-reviews/{id}/toggle-status', [ReviewJournalScheduleController::class, 'toggleStatus'])->name('schedule.journaltoggleStatus');

    # Conference
    Route::get('schedule/conference', [ReviewConferenceScheduleController::class, 'conferenceschedule'])->name('schedule.conference');
    Route::post('schedule/conference/store', [ReviewConferenceScheduleController::class, 'store'])->name('schedule.conferencestore');
    Route::get('schedule/conference/view', [ReviewConferenceScheduleController::class, 'viewconferenceschedule'])->name('schedule.conferenceview');
    Route::delete('schedule/conference/destroy/{id}', [ReviewConferenceScheduleController::class, 'destroy'])->name('schedule.conferencedestroy');
    Route::get('schedule/conference/edit/{id}', [ReviewConferenceScheduleController::class, 'edit'])->name('schedule.conferenceedit');
    Route::put('schedule/conference/update/{id}', [ReviewConferenceScheduleController::class, 'update'])->name('schedule.conferenceupdate');
    Route::put('schedule/conference/send/{id}', [ReviewConferenceScheduleController::class, 'upload'])->name('schedule.conferencesend');
    Route::get('papers/conferences/return', [ConferenceManagementController::class, 'returnConference'])->name('schedule.conferencereview');
    Route::delete('papers/conference-reviews/destroy/{id}', [ReviewConferenceScheduleController::class, 'destroyReturnConference'])->name('schedule.conferencereturndestroy');
    Route::put('papers/conference-reviews/{id}/toggle-status', [ReviewConferenceScheduleController::class, 'toggleStatus'])->name('schedule.conferencetoggleStatus');
});

# User list routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('user/reviewer', [UserController::class, 'reviewer'])->name('user.reviewer');
    Route::get('user/author', [UserController::class, 'author'])->name('user.author');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('user/editreviewer/{id}', [UserController::class, 'editreviewer'])->name('user.editreviewer');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::put('user/updatereviewer/{id}', [UserController::class, 'updatereviewer'])->name('user.updatereviewer');
    Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('user/approach/{id}', [UserController::class, 'approach'])->name('user.approach');
});

Route::get('/about', function () {
    return view('author.pages.about');
});

# Committee routes
Route::prefix('admin/committee')->name('admin.committee.')->group(function () {
    Route::get('/', [CommitteeController::class, 'index'])->name('index');
    Route::get('/create', [CommitteeController::class, 'create'])->name('create');
    Route::post('/store', [CommitteeController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CommitteeController::class, 'edit'])->name('edit');
    Route::put('/{id}', [CommitteeController::class, 'update'])->name('update');
    Route::delete('/{id}', [CommitteeController::class, 'destroy'])->name('destroy');
});

# Contact messages routes
Route::prefix('admin')->name('admin.contact.')->group(function () {
    Route::get('/contact/messages', [ContactController::class, 'index'])->name('messages');
    Route::get('/contact-messages/{id}', [ContactController::class, 'show'])->name('show');
    Route::get('/contact/messages/unread', [ContactController::class, 'unread'])->name('unread');
    Route::get('/contact/messages/responded', [ContactController::class, 'responded'])->name('responded');
    Route::delete('/contact-messages/{id}', [ContactController::class, 'destroy'])->name('destroy');
});

# Fees routes
Route::prefix('admin/fees')->name('admin.fees.')->group(function () {
    Route::get('/', [RegistrationInfoController::class, 'index'])->name('index');
    Route::get('/create', [RegistrationInfoController::class, 'create'])->name('create');
    Route::post('/store', [RegistrationInfoController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [RegistrationInfoController::class, 'edit'])->name('edit');
    Route::put('/{id}', [RegistrationInfoController::class, 'update'])->name('update');
    Route::delete('/{id}', [RegistrationInfoController::class, 'destroy'])->name('destroy');
});

# Journals routes
Route::prefix('admin/journals')->name('admin.journals.')->group(function () {
    Route::get('/', [JournalController::class, 'index'])->name('index');
    Route::get('/create', [JournalController::class, 'create'])->name('create');
    Route::post('/', [JournalController::class, 'store'])->name('store');
    Route::get('/{journal}/edit', [JournalController::class, 'edit'])->name('edit');
    Route::put('/{journal}', [JournalController::class, 'update'])->name('update');
    Route::delete('/{journal}', [JournalController::class, 'destroy'])->name('destroy');
});

# Conferences routes
Route::prefix('admin/conferences')->name('admin.conferences.')->group(function () {
    Route::get('/', [ConferenceController::class, 'index'])->name('index');
    Route::get('/create', [ConferenceController::class, 'create'])->name('create');
    Route::post('/', [ConferenceController::class, 'store'])->name('store');
    Route::get('/{conference}/edit', [ConferenceController::class, 'edit'])->name('edit');
    Route::put('/{conference}', [ConferenceController::class, 'update'])->name('update');
    Route::delete('/{conference}', [ConferenceController::class, 'destroy'])->name('destroy');
});

# Reviewer routes
Route::prefix('reviewer')->middleware('auth')->group(function () {
    Route::get('conference-review/{id}/edit', [ReviewerResponseController::class, 'editConferenceReview'])
        ->name('reviewer.editConferenceReview');

    Route::put('conference-review/{id}', [ReviewerResponseController::class, 'updateConference'])
        ->name('reviewer.updateConference');
});
