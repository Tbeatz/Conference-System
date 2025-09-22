<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Journal;
use App\Models\User;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Support\Carbon;

class JournalSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();
        $topics = Topic::all();

        // Check if enough users exist
        if ($users->count() < 2) {
            echo "Error: Not enough users for reviewer and author\n";
            return;
        }

        // Proceed if the data is valid
        $journals = [
            [
                'category_id' => 1,
                'topic_id' => 1,
                'description' => 'This is a sample journal description.',
                'paper_path' => 'papers/merged-sample.pdf',
                'start_date' => '2025-07-24',
                'end_date' => '2025-08-13',
                'publication_date' => '2025-09-03',
                'journal_website' => 'https://examplejournal.com',
                'reviewer_id' => $users->first()->id, // Ensure a valid user id exists
                'author_id' => $users->skip(1)->first()->id, // Another valid user id for author
                'contact_email' => 'editor@examplejournal.com',
                'status' => 'open',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more journals as needed
        ];

        // Insert journals
        foreach ($journals as $journal) {
            Journal::create($journal);
        }
    }
}
