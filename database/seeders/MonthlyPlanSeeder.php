<?php

namespace Database\Seeders;

use App\Models\plan;
use App\Models\MonthlyPlan;
use Illuminate\Database\Seeder;

class MonthlyPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $begin = new \DateTime('now');
        $end   = new \DateTime('2023-05-01');

        $different = $begin->diff($end);
        $days = $different->format('%a');//now do whatever you like with $days

        for($i=$begin; $i<=$end ;$i->modify('+1 day')) {
            $plan = new MonthlyPlan();
            $plan->title = "يجب مشاهده الدرس الاول";
            $plan->start = $i->format("Y-m-d");
            $plan->end = $i->modify('+1 day')->format("Y-m-d");
            $plan->save();
            if ($days > 1) {
                $i->modify('-1 day')->format("Y-m-d");
            }

        }
    }
}
