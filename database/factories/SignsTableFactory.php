<?php

use Faker\Generator as Faker;

$factory->define(App\Components\Sign\Models\Sign::class, function (Faker $faker) {
    return [
        'mb_id' => App\Components\User\Models\User::all()->random()->id,
        'company'  => $faker->company,
        'pay'  => $faker->numberBetween(100,1000),
        'day'  => $faker->date('Y-m-d'),
        'period'  => $faker->numberBetween(2,10),
        'keyword'  => $faker->word,
        'service'  => $faker->randomElement(array('홈페이지','블로그')),
        'phone'    => $faker->tollFreePhoneNumber,
        'email' => $faker->unique()->safeEmail,
        'comment'  => $faker->word,
        'file' => '0',
        'progress' => '0',
        'receipt'  => $faker->date('Y-m-d'),
        'homepage_url' => $faker->url
    ];
});
