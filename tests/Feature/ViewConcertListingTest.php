<?php

use App\Concert;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CustomTestCase;

/**
 * Class ViewConcertListingTest
 */
class ViewConcertListingTest extends CustomTestCase
{
    use RefreshDatabase;

    /**
     * @test 
     */
    public function can_view_published_concert()
    {
        $concert = factory(Concert::class)->states('published')->create(
            [
                'title' => 'The Red Chord',
                'subtitle' => 'with Animosity and Lethargy',
                'date' => Carbon::parse('December 13, 2016 8:00pm'),
                'ticket_price' => 3250,
                'venue' => 'The Mosh Pit',
                'venue_address' => '123 Example Lane',
                'city' => 'Laraville',
                'state' => 'ON',
                'zip' => '17916',
                'additional_information' => 'For tickets, call (555) 555-5555.',
            ]
        );

        $response = $this->get('concerts/' . $concert->id);
        $this->checkResponse($response);

        $response->assertSee('The Red Chord');
        $response->assertSee('with Animosity and Lethargy');
        $response->assertSee('December 13, 2016');
        $response->assertSee('8:00pm');
        $response->assertSee('32.50');
        $response->assertSee('The Mosh Pit');
        $response->assertSee('123 Example Lane');
        $response->assertSee('Laraville, ON 17916');
        $response->assertSee('For tickets, call (555) 555-5555.');

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function cannot_view_unpublished_concert()
    {
        $concert = factory(Concert::class)->states('unpublished')->create();

        $response = $this->get('concerts/' . $concert->id);

        $response->assertStatus(404);
    }
}
