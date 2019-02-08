<?php

namespace Tests\Feature;

use App\Deal;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\SavedDeal;

class SavedDealTest extends TestCase
{
    public function testItAUserCanViewedTheirSavedDeals()
    {
        $user = factory(User::class)->create();
        $deal = factory(Deal::class)->create();
        $savedDeal = SavedDeal::create([
            'user_id' => $user->id,
            'deal_id' => $deal->id,
        ]);


        $response = $this->actingAs($user)->json('GET', '/deals/saved');

        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $deal->title]);
    }

    public function testAUserCantViewSavedDealsOfAnotherUser()
    {
        $user1 = factory(User::class)->create();
        $deal = factory(Deal::class)->create();
        $savedDeal = SavedDeal::create([
            'user_id' => $user1->id,
            'deal_id' => $deal->id,
        ]);
        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user2)->json('GET', '/deals/saved');

        $response->assertStatus(200);
        $response->assertJsonMissing(['title' => $deal->title]);
    }

    public function testAUserCanSaveADeal()
    {
        $user = factory(User::class)->create();
        $deal = factory(Deal::class)->create();

        $response = $this->actingAs($user)->json('POST', '/deals/saved', [
            'deal_id' => $deal->id
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('saved_deals', ['user_id' => $user->id, 'deal_id' => $deal->id]);
    }

    public function testAUserCanDeleteASavedDeal()
    {
        $user = factory(User::class)->create();
        $deal = factory(Deal::class)->create();
        $user->savedDeals()->create(['deal_id' => $deal->id]);

        $response = $this->actingAs($user)->json('DELETE', '/deals/saved/'.$deal->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('saved_deals', ['user_id' => $user->id, 'deal_id' => $deal->id]);
    }
}
