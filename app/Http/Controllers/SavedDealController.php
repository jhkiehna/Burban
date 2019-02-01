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
        $deals = Deal::forUser(auth()->user());

        return new DealCollection($deals->paginate());
    }

    public function store(Request $request)
    {
        $deal = auth()->user()->savedDeals()->create($request->all());

        return new DealResource($deal);
    }

    public function destroy($dealId)
    {
        $savedDeal = auth()->user()->savedDeals()->where('deal_id', $dealId)->firstOrFail();
        $savedDeal->delete();

        return response(null, 204);
    }
}
