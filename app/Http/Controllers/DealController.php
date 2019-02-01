<?php

namespace App\Http\Controllers;

use App\Deal;
use Illuminate\Http\Request;
use App\Http\Resources\DealResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\DealCollection;

class DealController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Deal::class, 'deal');
    }

    public function index()
    {
        return new DealCollection(Deal::paginate());
    }

    public function show(Deal $deal)
    {
        return new DealResource($deal);
    }

    public function store(Request $request)
    {
        $deal = Auth::user()->business->deals()->create($request->all());

        return new DealResource($deal);
    }

    public function update(Request $request, Deal $deal)
    {
        $deal->update($request->all());

        return new DealResource($deal);
    }

    public function destroy(Deal $deal)
    {
        //
    }
}
