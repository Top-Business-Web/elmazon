<?php

namespace App\Imports;

use App\Models\MotivationalSentences;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class MotivationalImport implements ToCollection, WithHeadingRow

{

    public function collection(Collection $collection){

        DB::table('motivational_sentences')->delete();
        for ($i = 0; $i < count($collection); $i++) {

            MotivationalSentences::query()
                ->updateOrCreate([
                    'percentage' => $collection[$i]['percentage'],
                ],[
                    'title_ar'    => $collection[$i]['title_ar'],
                    'title_en'    => $collection[$i]['title_en'],
                    'percentage' => $collection[$i]['percentage'],
                ]);
        }
    }

}
