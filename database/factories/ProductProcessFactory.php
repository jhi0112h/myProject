<?php

use Faker\Generator as Faker;

$factory->define(App\Components\Sign\Models\ProductProcess::class, function (Faker $faker) {
    return [
        'sign_id' => App\Components\Sign\Models\Sign::all()->random()->id,
        'state'  => $faker->randomElement(array('접수중','이메일요청','제작완료','보류','취소')),
        'name'  => $faker->name,
        'content'  => $faker->word,
        'file' => '0',
    ];
});
