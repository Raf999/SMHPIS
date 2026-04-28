<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cs = \App\Models\Department::create(['name' => 'Computer Science']);
        $cs->courses()->createMany([
            ['name' => 'Artificial Intelligence', 'code' => 'CS401'],
            ['name' => 'Web Development', 'code' => 'CS302'],
            ['name' => 'Data Structures', 'code' => 'CS201'],
        ]);

        $bus = \App\Models\Department::create(['name' => 'Business Administration']);
        $bus->courses()->createMany([
            ['name' => 'Business Ethics', 'code' => 'BUS101'],
            ['name' => 'Market Analysis', 'code' => 'BUS205'],
        ]);

        $arts = \App\Models\Department::create(['name' => 'Fine Arts']);
        $arts->courses()->createMany([
            ['name' => 'Digital Illustration', 'code' => 'ART301'],
            ['name' => 'History of Art', 'code' => 'ART101'],
        ]);
    }
}
