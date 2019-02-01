<?php

namespace Tests\Feature;

use App\Business;
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

    public function testItCanReturnAListOfDealsForABusiness()
    {
        $business = factory(Business::class)->create();
        $deal = factory(Deal::class)->create([
            'business_id' => $business->id
        ]);

        $response = $this->json('GET', '/businesses/'. $business->id .'/deals/');

        $response->assertStatus(200);
        $response->assertJsonFragment(['description' => $deal->description]);
    }

    public function testABusinessCanCreateADeal()
    {
        $business = factory(Business::class)->create();

        $response = $this->actingAs($business->user)->json('POST', '/deals', [
            'title' => 'testDeal',
            'description' => 'test Description'
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment(['title' => 'testDeal']);
        $this->assertDatabaseHas('deals', ['title' => 'testDeal']);
    }

    public function testABusinessCanUpdateADeal()
    {
        $business = factory(Business::class)->create();
        $deal = factory(Deal::class)->create([
            'business_id' => $business->id
        ]);

        $response = $this->actingAs($business->user)->json('PATCH', '/deals/'. $deal->id, [
            'title' => 'testDeal2',
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'testDeal2']);
        $this->assertDatabaseHas('deals', ['title' => 'testDeal2']);
    }
}
