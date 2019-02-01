<?php

namespace App\Http\Controllers;

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
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
