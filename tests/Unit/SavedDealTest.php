<?php

namespace Tests\Unit;

use App\User;
use App\Deal;
use App\Business;
use App\SavedDeal;
use Tests\TestCase;

class SavedDealTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Deal::disableSearchSyncing();
        Business::disableSearchSyncing();
    }

    public function testASavedDealIsDeletedWhenTheDealIsDeletedByABusiness()
    {
        $user = factory(User::class)->create();
        $deal = factory(Deal::class)->create();
        SavedDeal::create([
            'user_id' => $user->id,
            'deal_id' => $deal->id,
        ]);

        $deal->delete();
        
        $this->assertDatabaseMissing('saved_deals', ['deal_id' => $deal->id]);
    }
}
