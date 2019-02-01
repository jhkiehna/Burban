<?php

namespace Tests\Feature;

use App\Deal;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\SavedDeal;

class DealTest extends TestCase
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
}
