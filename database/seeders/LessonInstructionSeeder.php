<?php

namespace Database\Seeders;

use App\Models\AllExam;
use App\Models\LessonInstruction;
use Illuminate\Database\Seeder;

class LessonInstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        LessonInstruction::create([

            'instruction' => '1- بامكان الطالب الضغط على تاجيل السؤال
            ليظهر بلون مختلف ويمكن الرجوع للحل مرة
            اخرى .',
            'trying_number' => 2,
            'number_of_question' => 3,
            'quiz_minute' => 15,
            'all_exam_id' => AllExam::first()->id,
        ]);
    }
}
