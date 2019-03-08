<?php

namespace App\Http\Controllers;

use App\Deal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\DealRequest;
use App\Http\Resources\DealResource;
use App\Http\Resources\DealCollection;

class DealController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Deal::class, 'deal');
    }

    public function index()
    {
        return new DealCollection(Deal::where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->paginate());
    }

    public function show(Deal $deal)
    {
        return new DealResource($deal);
    }

    public function store(DealRequest $request)
    {
        $deal = auth()->user()->business->deals()->create($request->all());

        return new DealResource($deal);
    }

    public function update(DealRequest $request, Deal $deal)
    {
        $deal->update($request->all());

        return new DealResource($deal);
    }

    public function destroy(Deal $deal)
    {
        $deal->delete();

        return response(null, 204);
    }
}
