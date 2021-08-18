<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new Status();
        $status->title = 'Новый';
        $status->slug = 'new';
        $status->save();

        $status1 = new Status();
        $status1->title = 'Оплачен';
        $status1->slug = 'paid';
        $status1->save();

        $status2 = new Status();
        $status2->title = 'Отправлен';
        $status2->slug = 'shiped';
        $status2->save();

        $status3 = new Status();
        $status3->title = 'Выполнен';
        $status3->slug = 'done';
        $status3->save();
    }
}
