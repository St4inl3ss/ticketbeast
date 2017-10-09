<?php
/**
 * Created by PhpStorm.
 * User: stainlessphil
 * Date: 17/09/17
 * Time: 9:48 PM
 */

namespace Tests\Unit;

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CustomTestCase;
use function factory;

class ConcertTest extends CustomTestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_formatted_date()
    {
        $concert = factory(Concert::class)->make(
            [
                'date' => Carbon::parse('2016-12-01 8:00pm')
            ]
        );

        $this->assertEquals('December 1, 2016', $concert->formatted_date);
    }

    /**
     * @test
     */
    public function can_get_formatted_start_time()
    {
        $concert = factory(Concert::class)->make(
            [
                'date' => Carbon::parse('2016-12-01 17:00:00'),
            ]
        );

        self::assertEquals('5:00pm', $concert->formatted_start_time);
    }

    /**
     * @test
     */
    public function can_get_ticket_price_in_dollars()
    {
        $concert = factory(Concert::class)->make(
            [
                'ticket_price' => 6750
            ]
        );

        self::assertEquals('67.50', $concert->ticket_price_in_dollars);
    }

    /**
     * @test
     */
    public function concerts_with_a_published_at_date_are_published()
    {
        $publishedConcertA = factory(Concert::class)->create(['published_at' => Carbon::parse('-1 week')]);
        $publishedConcertB = factory(Concert::class)->create(['published_at' => Carbon::parse('-1 week')]);
        $unpublishedConcert = factory(Concert::class)->create(['published_at' => null]);

        $publishedConcerts = Concert::published()->get();

        self::assertTrue($publishedConcerts->contains($publishedConcertA));
        self::assertTrue($publishedConcerts->contains($publishedConcertB));
        self::assertFalse($publishedConcerts->contains($unpublishedConcert));
    }

    /**
     * @test
     */
    public function can_order_concert_tickets()
    {

        /**
         * @var Concert $concert
         */
        $concert = factory(Concert::class)->create();

        $order = $concert->orderTickets('jane@example.com', 3);

        self::assertEquals('jane@example.com', $order->email);
        self::assertEquals(3, $order->tickets()->count());
    }
}