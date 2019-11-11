<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'isbn' => $faker->isbn10,
        'authors' => $faker->name,
        'number_of_pages' => $faker->numberBetween(100, 500),
        'publisher' => $faker->company,
        'release_date' => now(),
    ];
});
