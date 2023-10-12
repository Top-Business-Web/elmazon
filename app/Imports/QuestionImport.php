<?php
//
//namespace App\Imports;
//
//use App\Models\Question;
//use Maatwebsite\Excel\Concerns\ToModel;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;
//
//
//class QuestionImport implements ToModel , WithHeadingRow
//
//{
//    public function model(array $row): Question
//    {
////        dd($row);
//        return new Question([
//            'question'    => $row['question'],
//            'degree'    => $row['degree'],
//            'difficulty'    => $row['difficulty_low_mid_high'],
//            'type'    => 'video',
//            'season_id'    => 1,
//            'term_id'    => 1,
//            'examable_type'    => 'App\Models\VideoParts',
//            'examable_id'    => 1,
//        ]);
//    }
//
//}


namespace App\Imports;

use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToCollection, WithHeadingRow
{



    public function collection(Collection $collection)
    {

//        dd($collection);
        for ($i = 0; $i < count($collection); $i++) {

            Question::query()
                ->updateOrCreate([
                    'id' => $collection[$i]['id'],
                ], [
                    'question' => $collection[$i]['question'],
                    'difficulty' => $collection[$i]['difficulty_lowmidhigh'],
                    'type' => $collection[$i]['typesubject_classlessonvideoall_examlife_exam'],
                    'question_type' => $collection[$i]['questiontypechoicetext'],
                    'degree' => $collection[$i]['degree'],
                    'season_id' => $collection[$i]['season'],
                    'term_id' => $collection[$i]['term'],
                ]);
        }
    }

}
