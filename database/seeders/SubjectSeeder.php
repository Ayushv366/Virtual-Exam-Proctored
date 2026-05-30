<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            ['name' => 'Database Systems', 'code' => 'CSE-DBMS', 'description' => 'Relational database concepts, SQL, indexing, and normalization.'],
            ['name' => 'Computer Networks', 'code' => 'CSE-CN', 'description' => 'OSI model, routing, switching, and network security.'],
            ['name' => 'Operating Systems', 'code' => 'CSE-OS', 'description' => 'Processes, memory management, scheduling, and file systems.'],
            ['name' => 'Web Technologies', 'code' => 'CSE-WEB', 'description' => 'HTML, CSS, JavaScript, HTTP, and Laravel-based web development.'],
        ];

        foreach ($subjects as $subject) {
            Subject::updateOrCreate(['code' => $subject['code']], $subject + ['is_active' => true]);
        }
    }
}
