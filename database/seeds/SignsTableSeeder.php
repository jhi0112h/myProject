<?php

use Illuminate\Database\Seeder;

class SignsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Components\Sign\Models\Sign::truncate();
        factory('App\Components\Sign\Models\Sign', 100)->create();
    }
}
