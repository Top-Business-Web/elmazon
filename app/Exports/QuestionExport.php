<?php

namespace App\Exports;

use App\Models\Question;
use App\Models\User;

use Illuminate\Support\Collection;
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
            'C' => 30,
            'D' => 40,
        ];
    }
    public function headings(): array
    {
        return [
            '#',
            'Question',
            'Degree',
            'Difficulty (low , mid , high)',
        ];
    }
    /**
     * @return Collection
     */

    public function collection(): Collection

    {

        return Question::get(['id','question','degree','difficulty']);

    }

}
