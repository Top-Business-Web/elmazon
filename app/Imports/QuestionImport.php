<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class QuestionImport implements ToModel , WithHeadingRow

{
    public function model(array $row): Question
    {
//        dd($row);
        return new Question([
            'question'    => $row['question'],
            'degree'    => $row['degree'],
            'difficulty'    => $row['difficulty_low_mid_high'],
            'type'    => 'video',
            'season_id'    => 1,
            'term_id'    => 1,
            'examable_type'    => 'App\Models\VideoParts',
            'examable_id'    => 1,
        ]);
    }

}
