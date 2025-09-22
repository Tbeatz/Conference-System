<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $categoryId = \App\Models\Category::first()?->id ?? 1; // default to 1 if no categories

        Event::insert([
            [
                'category_id'           => $categoryId,
                'title'                 => 'AI & Machine Learning Summit',
                'description'           => 'A premier conference focused on advancements in AI and ML.',
                'start_date'            => now()->addDays(10),
                'end_date'              => now()->addDays(12),
                'location'              => 'San Francisco, CA',
                'publication_partner'   => 'Springer',
                'submission_deadline'   => now()->addDays(3),
                'acceptance_date'       => now()->addDays(6),
                'camera_ready_deadline' => now()->addDays(8),
                'event_website'         => 'https://ai-summit.org',
                'organizer'             => 'Dr. John Doe',
                'contact_email'         => 'contact@ai-summit.org',
                'status'                => 'open',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'category_id'           => $categoryId,
                'title'                 => 'International Conference on Cybersecurity',
                'description'           => 'A global event for researchers in cybersecurity.',
                'start_date'            => now()->addDays(20),
                'end_date'              => now()->addDays(22),
                'location'              => 'Berlin, Germany',
                'publication_partner'   => 'IEEE',
                'submission_deadline'   => now()->addDays(10),
                'acceptance_date'       => now()->addDays(13),
                'camera_ready_deadline' => now()->addDays(17),
                'event_website'         => 'https://cyberconf.io',
                'organizer'             => 'CyberLab Team',
                'contact_email'         => 'info@cyberconf.io',
                'status'                => 'upcoming',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
            [
                'category_id'           => $categoryId,
                'title'                 => 'Virtual Education & eLearning Conference',
                'description'           => 'Focused on innovations in online education and edtech.',
                'start_date'            => now()->addDays(5),
                'end_date'              => now()->addDays(6),
                'location'              => null, // Journal-type or virtual
                'publication_partner'   => 'Elsevier',
                'submission_deadline'   => now()->addDays(2),
                'acceptance_date'       => now()->addDays(3),
                'camera_ready_deadline' => now()->addDays(4),
                'event_website'         => 'https://elearningconf.org',
                'organizer'             => 'Prof. Jane Smith',
                'contact_email'         => 'elearn@educonf.org',
                'status'                => 'published',
                'created_at'            => now(),
                'updated_at'            => now(),
            ],
        ]);
    }
}