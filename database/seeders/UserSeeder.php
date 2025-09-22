<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks for truncating
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_user')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ensure the roles exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $authorRole = Role::firstOrCreate(['name' => 'author']);
        $reviewerRole = Role::firstOrCreate(['name' => 'reviewer']);
        // Create admin user
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);

        //  Create author user
        $authorUser = User::firstOrCreate(
            ['email' => 'author@gmail.com'],
            [
                'name' => 'Author User',
                'password' => Hash::make('password'),
            ]
        );
        $authorUser->roles()->syncWithoutDetaching([$authorRole->id]);

        $reviewerUser = User::firstOrCreate(
            ['email' => 'reviewer@gmail.com'],
            [
                'name' => 'Reviewer User',
                'password' => Hash::make('password'),
            ]
        );
        $reviewerUser->roles()->syncWithoutDetaching([$reviewerRole->id]);
        // echo "Admin and Author users created with their roles attached successfully.\n";
    }
}
