<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'conference',
        ];

        foreach ($categories as $name) {
            // Insert only if not exists
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
