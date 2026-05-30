<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::query()->where('role', 'admin')->value('id');

        Announcement::updateOrCreate(
            ['title' => 'Semester Examination Rules'],
            [
                'message' => 'Students must keep the browser in full screen mode, allow the camera, and avoid copy-paste actions.',
                'audience' => 'all',
                'publish_at' => now(),
                'is_active' => true,
                'created_by' => $adminId,
            ]
        );

        Announcement::updateOrCreate(
            ['title' => 'Faculty Review Window'],
            [
                'message' => 'Faculty can review suspicious logs and published results from the faculty dashboard.',
                'audience' => 'faculty',
                'publish_at' => now(),
                'is_active' => true,
                'created_by' => $adminId,
            ]
        );
    }
}
