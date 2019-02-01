<?php

namespace Tests\Feature;

use App\Deal;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DealTest extends TestCase
{
    public function testItCanReturnAListOfDeals()
    {
        $deal = factory(Deal::class)->create();

        $response = $this->json('GET', '/deals');

        $response->assertStatus(200);
        $response->assertJsonFragment(['description' => $deal->description]);
    }

    public function testItCanReturnASingleDeal()
    {
        $deal = factory(Deal::class)->create();

        $response = $this->json('GET', '/deals/'.$deal->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['description' => $deal->description]);
    }
}
