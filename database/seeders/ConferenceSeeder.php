<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Conference;
use App\Models\User;
use App\Models\Category;
use App\Models\Topic;
use Illuminate\Support\Carbon;

class ConferenceSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all(); // Ensure you have users in the database
        $categories = Category::all(); // Ensure you have categories
        $topics = Topic::all(); // Ensure you have topics

        // Example data to insert conferences
        $conferences = [
            [
                'category_id' => 1,
                'topic_id' => 2,
                'description' => 'This is a sample conference description.',
                'paper_path' => 'papers/sample-conference.pdf',
                'start_date' => '2025-07-29',
                'end_date' => '2025-08-18',
                'publication_date' => '2025-08-17',
                'conference_website' => 'https://exampleconference.com',
                'reviewer_id' => $users->first()->id, // Assure this is a valid user id
                'author_id' => $users->skip(1)->first() ? $users->skip(1)->first()->id : $users->first()->id,

                'contact_email' => 'info@exampleconference.com',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Add more conferences as needed
        ];

        // Insert conferences
        foreach ($conferences as $conference) {
            Conference::create($conference);
        }
    }
}
