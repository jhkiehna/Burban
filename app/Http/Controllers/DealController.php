<?php

namespace App\Http\Controllers;

use App\Deal;
use Illuminate\Http\Request;
use App\Http\Resources\DealResource;
use App\Http\Resources\DealCollection;

class DealController extends Controller
{
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
    }

    public function update(Request $request, Deal $deal)
    {
        //
    }

    public function destroy(Deal $deal)
    {
        //
    }
}
