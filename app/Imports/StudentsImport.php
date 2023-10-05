<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToCollection, WithHeadingRow
{

   public function generateUniqueCode(): string
   {

        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 10;

        $code = '';

        while (strlen($code) < 10) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code.$character;
        }


        return $code;

    }

    public function collection(Collection $collection){

        for ($i = 0; $i < count($collection); $i++) {

            User::query()
            ->updateOrCreate([
                'code' => $collection[$i]['code'],
            ],[
                'name' => $collection[$i]['name'],
                'password' => Hash::make('123456'),
                'birth_date' => Carbon::parse($collection[$i]['birth_date'])->format('Y-m-d'),
                'phone' => $collection[$i]['phone'],
                'father_phone' => $collection[$i]['father_phone'],
                'center' => $collection[$i]['center'],
                'user_status' => $collection[$i]['user_status'],
                'code' => $collection[$i]['code'] ?? $this->generateUniqueCode(),
                'date_start_code' => Carbon::parse($collection[$i]['date_start_code'])->format('Y-m-d'),
                'date_end_code' => Carbon::parse($collection[$i]['date_end_code'])->format('Y-m-d'),
                'season_id' => $collection[$i]['season_id'],
                'country_id' => $collection[$i]['country_id'],
            ]);
        }
    }

}
