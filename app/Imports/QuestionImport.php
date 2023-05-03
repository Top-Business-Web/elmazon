<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\User;

use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;


class QuestionImport implements WithHeadingRow, ToModel

{
    public function headings(): array
    {
        return [
            '#',
            'Question',
        ];
    }

    public function model(array $row): Question
    {
        return new Question([
            'question'    => $row['question'],
            'type'    => 'video',
            'difficulty'    => 'low',
            'season_id'    => 1,
            'term_id'    => 1,
            'examable_type'    => 'App\Models\VideoParts',
            'examable_id'    => 1,
        ]);
    }

}
