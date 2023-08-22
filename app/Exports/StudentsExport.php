<?php

namespace App\Exports;

use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsExport implements FromCollection , WithHeadings ,WithColumnWidths
{
    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 10,

        ];
    }

    public function headings(): array
    {
        return [
            'name',
            'birth_date',
            'phone',
            'father_phone',
            'center',
            'user_status',
            'code',
            'date_start_code',
            'date_end_code',
            'season_id',
            'country_id'
        ];
    }

    public function collection(): Collection{

        return User::get([
            'name',
            'birth_date',
            'phone',
            'father_phone',
            'center',
            'user_status',
            'code',
            'date_start_code',
            'date_end_code',
            'season_id',
            'country_id'
            ]);
    }
}
