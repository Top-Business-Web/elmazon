<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name_ar' => 'اسلام محمد',
            'name_en' => 'Islam Mohamed',
            'season_id' => 1,
            'group_id' => 1,
            'country_id' => 1,
            'password' =>  Hash::make('123456'),
            'phone' => '01062933188',
            'father_phone' => '1005717155',
            'user_type' => 'student',
            'image' => 'avatar.jpg',
            'login_status' => 'logout',
            'user_status' => 'active',
            'code' => rand(1,3000),
            'date_start_code' => '2022-02-20',
            'date_end_code' => '2022-07-20',

        ]);
    }
}
