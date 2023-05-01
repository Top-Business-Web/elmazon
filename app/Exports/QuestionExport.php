<?php

namespace App\Exports;

use App\Models\Question;
use App\Models\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;


class QuestionExport implements FromCollection , WithHeadings ,WithColumnWidths

{

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 100,
        ];
    }
    public function headings(): array
    {
        return [
            '#',
            'Question',
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()

    {

        return Question::get(['id','question']);

    }

}
