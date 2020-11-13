<?php

namespace Database\Factories;

use App\Models\Backend\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        // 'avatar' => 'https://via.placeholder.com/150',
        // 'email_verified_at' => now(),
        'author'           => rand(1, 30),
        'sku'               => 'ASD123FGH543',
        'name'              => $faker->name,
        // 'product_code'      => '',
        'shop_id'           => rand(1, 30),
        'price'             => rand(200000, 10000000),
        'promotion_price'   => rand(200000, 10000000),
        'long_desc'         => 'Long description',
        'short_desc'        => 'Short decription',
        'thumb'             => 'https://via.placeholder.com/150',
        'image'             => 'https://via.placeholder.com/150, https://via.placeholder.com/150, https://via.placeholder.com/150',
        'categories'        => rand(1, 30),
        'amount'            => rand(50, 100),
        'location'          => 'Nguyen Huu Canh, Binh Thanh, Tp HCM',
        'promotion_code'    => '',
        'trade_mark'        => 'Conversion',
        'made'              => 'Viet Nam',
        'user_manual'       => 'Huong dan su dung',
        'img_user_manual'   => 'https://via.placeholder.com/150',
        'consumed'          => rand(1, 30),
        'status'            => rand(0, 1),
        'book'              => rand(0, 1),
        'hidden'            => rand(0, 1),
        'slug'              => $faker->regexify('[A-Za-z0-9]{' . mt_rand(10, 20) . '}'),
        'infringe'          => rand(0, 1),
        'add_to_card'       => rand(1, 30)
        // 'deleted_by'       => ''
    ];
});

// $factory->define(Message::class, function (Faker $faker) {
//     do {
//         $from = rand(1, 30);
//         $to = rand(1, 30);
//         $is_read = rand(0, 1);
//     } while ($from === $to);

//     return [
//         'from' => $from,
//         'to' => $to,
//         'message' => $faker->sentence,
//         'is_read' => $is_read
//     ];
// });
