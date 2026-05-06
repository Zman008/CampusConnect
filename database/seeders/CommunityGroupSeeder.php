<?php

namespace Database\Seeders;

use App\Models\CommunityGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunityGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CommunityGroup::create([
            'name' => 'Computer Science',
            'description' => 'Discuss CS topics, programming, algorithms, and web development.',
        ]);

        CommunityGroup::create([
            'name' => 'Engineering',
            'description' => 'Engineering discussions, projects, and technical challenges.',
        ]);

        CommunityGroup::create([
            'name' => 'Business',
            'description' => 'Business and management talks, entrepreneurship, and case studies.',
        ]);

        CommunityGroup::create([
            'name' => 'Arts & Humanities',
            'description' => 'Arts, literature, history, and cultural discussions.',
        ]);

        CommunityGroup::create([
            'name' => 'Science',
            'description' => 'Physics, chemistry, biology, and other sciences.',
        ]);

        CommunityGroup::create([
            'name' => 'General Discussion',
            'description' => 'General campus life, announcements, and off-topic discussions.',
        ]);
    }
}
