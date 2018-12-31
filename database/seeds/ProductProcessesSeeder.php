<?php

use Illuminate\Database\Seeder;

class ProductProcessesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Components\Sign\Models\ProductProcess::truncate();
        factory('App\Components\Sign\Models\ProductProcess', 100)->create();
    }
}
