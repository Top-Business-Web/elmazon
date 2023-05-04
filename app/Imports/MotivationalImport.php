<?php

namespace App\Imports;

use App\Models\MotivationalSentences;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MotivationalImport implements ToModel , WithHeadingRow

{
    public function model(array $row): MotivationalSentences
    {
//        dd($row);
        return new MotivationalSentences([
            'title_ar'    => $row['title_ar'],
            'title_en'    => $row['title_en'],
            'percentage' => $row['percentage'],
        ]);
    }

}
