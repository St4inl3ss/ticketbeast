<?php
/**
 * Created by PhpStorm.
 * User: stainlessphil
 * Date: 17/09/17
 * Time: 9:59 PM
 */

use App\Concert;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var Factory $factory */
$factory->define(
    Concert::class, function (Faker $faker) {

    return [
        'title' => 'Example Band',
        'subtitle' => 'with the Fake Openers',
        'date' => Carbon::parse('+ 2 weeks'),
        'ticket_price' => 2000,
        'venue' => 'The example venue',
        'venue_address' => '123 Example Lane',
        'city' => 'Fakeville',
        'state' => 'ON',
        'zip' => '90210',
        'additional_information' => 'Some sample additional information',
    ];
}

);

$factory->state(
    Concert::class, 'published', function (Faker $faker) {
    return [
        'published_at' => Carbon::parse('-1 week')
    ];
}
);

$factory->state(
    Concert::class, 'unpublished', function (Faker $faker) {
    return [
        'published_at' => null
    ];
}
);
