<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{

    public function run()
    {
        $teacher = Teacher::query()->create([
            'name'=> 'ahmed',
            'email'=> 'ahmed@gmail.com',
            'password'=> bcrypt('ahmed@gmail.com'),
            'active'=> 1,
            'type'=> 1,
        ]);
    }


} //end of class
