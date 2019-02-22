<?php

namespace App\Http\Controllers;

use App\Http\Resources\DealResource;
use App\Deal;
use App\SavedDeal;
use Illuminate\Http\Request;
use App\Http\Resources\DealCollection;

class SavedDealController extends Controller
{
    public function index()
    {
        return new DealCollection(auth()->user()->savedDeals->map->deal);
    }

    public function store(Request $request)
    {
        return new DealResource(auth()->user()->savedDeals()->create($request->all()));
    }

    public function destroy($dealId)
    {
        $savedDeal = auth()->user()->savedDeals()->where('deal_id', $dealId)->firstOrFail();
        $savedDeal->delete();

        return response(null, 204);
    }
}
