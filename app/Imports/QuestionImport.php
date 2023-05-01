<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\User;

use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;


class QuestionImport implements WithHeadingRow, ToModel

{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        return new Question([
            'question'    => $row['question'],
        ]);
    }

}
