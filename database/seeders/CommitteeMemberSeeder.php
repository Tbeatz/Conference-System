<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommitteeMember;

class CommitteeMemberSeeder extends Seeder
{
    // public function run(): void
    // {
    //     $members = [
    //         [
    //             'name' => 'Yuzana',
    //             'title' => 'Prof.',
    //             'position' => 'General Chair',
    //             'affiliation' => 'Rector, University of Computer Studies, Pyay',
    //             'country' => 'Myanmar',
    //         ],
    //         [
    //             'name' => 'Mie Mie Khin',
    //             'title' => 'Prof.',
    //             'position' => 'Program Chair',
    //             'affiliation' => 'Rector, University of Computer Studies, Yangon',
    //         ],
    //         // Organizing Committee Members
    //         ['name' => 'Win Aye', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Rector, Myanmar Institute of Information Technology'],
    //         ['name' => 'Thandar Thein', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Rector, Polytechnic University (McuBin)'],
    //         ['name' => 'Thinn Thu Naing', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Rector, Polytechnic University (Kyaing Tong)'],
    //         ['name' => 'Khin Marlar Tun', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Rector, University of Computer Studies (Hpa-An)'],
    //         ['name' => 'Ni Lar Thein', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Rector, University of Computer Studies (Thaton)'],
    //         ['name' => 'Ei Ei Hlaing', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Rector, University of Computer Studies (Taungoo)'],
    //         ['name' => 'Soe Soe Khaing', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Rector, University of Computer Studies (Monywa)'],
    //         ['name' => 'Naw Soe Soe Aung', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Rector, University of Computer Studies (Lashio)'],
    //         ['name' => 'Soe Lin Aung', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Acting Rector, Naypyitaw State Polytechnic University', 'is_acting' => true],
    //         ['name' => 'Tin Bhone Kyaw', 'title' => 'Dr.', 'position' => 'Member', 'affiliation' => 'President, IEEE Myanmar Subsection'],
    //         ['name' => 'Tin Myat Htwe', 'title' => 'Prof.', 'position' => 'Member', 'affiliation' => 'Pro-Rector, University of Information Technology'],
    //     ];

    //     foreach ($members as $member) {
    //         CommitteeMember::create($member);
    //     }
    // }
    public function run(): void
    {
        $members = [
            [
                'name' => 'Yuzana',
                'title' => 'Prof.',
                'role' => 'general_chair',
                'affiliation' => 'Rector, University of Computer Studies, Pyay',
                'country' => 'Myanmar',
            ],
            [
                'name' => 'Mie Mie Khin',
                'title' => 'Prof.',
                'role' => 'program_chair',
                'affiliation' => 'Rector, University of Computer Studies, Yangon',
            ],
            // Organizing Committee Members
            ['name' => 'Win Aye', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Rector, Myanmar Institute of Information Technology'],
            ['name' => 'Thandar Thein', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Rector, Polytechnic University (McuBin)'],
            ['name' => 'Thinn Thu Naing', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Rector, Polytechnic University (Kyaing Tong)'],
            ['name' => 'Khin Marlar Tun', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Rector, University of Computer Studies (Hpa-An)'],
            ['name' => 'Ni Lar Thein', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Rector, University of Computer Studies (Thaton)'],
            ['name' => 'Ei Ei Hlaing', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Rector, University of Computer Studies (Taungoo)'],
            ['name' => 'Soe Soe Khaing', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Rector, University of Computer Studies (Monywa)'],
            ['name' => 'Naw Soe Soe Aung', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Rector, University of Computer Studies (Lashio)'],
            ['name' => 'Soe Lin Aung', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Acting Rector, Naypyitaw State Polytechnic University', 'is_acting' => true],
            ['name' => 'Tin Bhone Kyaw', 'title' => 'Dr.', 'role' => 'member', 'affiliation' => 'President, IEEE Myanmar Subsection'],
            ['name' => 'Tin Myat Htwe', 'title' => 'Prof.', 'role' => 'member', 'affiliation' => 'Pro-Rector, University of Information Technology'],
        ];

        foreach ($members as $member) {
            CommitteeMember::create($member);
        }
    }
}
