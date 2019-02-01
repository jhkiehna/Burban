<?php

namespace Tests\Feature;

use App\Business;
use App\Deal;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DealTest extends TestCase
{
    public function testItCanReturnAListOfBusinesses()
    {
        $business = factory(Business::class)->create();

        $response = $this->json('GET', '/businesses/'. $business->id);

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $business->name]);
    }
}
