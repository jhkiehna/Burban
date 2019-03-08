<?php

namespace Tests\Feature;

use App\Business;
use App\Deal;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class DealTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Deal::disableSearchSyncing();
        Business::disableSearchSyncing();
    }

    public function testItCanReturnAListOfDeals()
    {
        $deal = factory(Deal::class)->create();

        $response = $this->json('GET', '/deals');

        $response->assertStatus(200);
        $response->assertJsonFragment(['description' => $deal->description]);
    }

    public function testItDoesntReturnDealsThatHaveEnded()
    {
        list($deal1, $deal2) = factory(Deal::class, 2)->create([
            'start_date' => Carbon::now()->subDays(7),
            'end_date' => Carbon::now()->subDays(1),
        ]);
        $deal1->update(['end_date' => Carbon::now()->addDays(7)]);

        $response = $this->json('GET', '/deals');

        $response->assertStatus(200);
        $response->assertJsonFragment([$deal1->description]);
        $response->assertJsonMissing([$deal2->description]);
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
            'description' => 'test Description',
            'start_date' => Carbon::now()->toDateString(),
            'end_date' => Carbon::now()->addDays(7)->toDateString(),
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

    public function testABusinessCantEditTheDealsOfAnotherBusiness()
    {
        $business = factory(Business::class)->create();
        $deal = factory(Deal::class)->create([
            'business_id' => $business->id
        ]);

        $business2 = factory(Business::class)->create();

        $response = $this->actingAs($business2->user)->json('PATCH', '/deals/'. $deal->id, [
            'title' => 'testDeal2',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('deals', ['title' => 'testDeal2']);
    }

    public function testARegularUserCantCreateADeal()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/deals/', [
            'title' => 'testDeal',
            'description' => 'test Description',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('deals', ['title' => 'testDeal']);
    }

    public function testABusinessCanDeleteADeal()
    {
        $business = factory(Business::class)->create();
        $deal = factory(Deal::class)->create([
            'business_id' => $business->id
        ]);

        $response = $this->actingAs($business->user)->json('DELETE', '/deals/'. $deal->id);

        $deal->refresh();

        $response->assertStatus(204);
        $this->assertTrue($deal->deleted_at != null);
    }
}
