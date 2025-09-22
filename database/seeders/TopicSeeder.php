<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Topic;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            'Advanced Networking Technologies',
            'Artificial Intelligence and Machine Learning',
            'Big Data Analytics',
            'Blockchain Technology and Applications',
            'Cloud Computing',
            'Computational Intelligence and Mathematical Modelling',
            'Computer Vision and Image Processing',
            'Cybersecurity and Privacy in Information Systems',
            'Database and Data Mining',
            'Deep Learning Techniques',
            'Embedded Systems and Digital Signal Processing',
            'Internet of Things (IoT) and Smart Systems',
            'Mobile and Ubiquitous Computing',
            'Modeling and Simulation',
            'Natural Language Processing',
            'Parallel and Distributed Systems',
            'Remote Sensing and Geospatial Information Systems',
            'Robotics and Automation Systems',
            'Software Engineering and Development Methodologies',
            'Theoretical Computer Science',
            'Web and Internet Computing',
        ];

        foreach ($topics as $name) {
            // Check if the topic already exists, if not, create it
            Topic::firstOrCreate(
                ['name' => $name],
                ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }
    }
}
