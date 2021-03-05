<?php

namespace Database\Seeders;

use App\Models\StudentProfile;
use Illuminate\Database\Seeder;

class StudentProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StudentProfile::factory(100)->create();
    }
}
