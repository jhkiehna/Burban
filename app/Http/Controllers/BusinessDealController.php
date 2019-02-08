<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\DealCollection;
use App\Business;

class BusinessDealController extends Controller
{
    public function index(Business $business)
    {
        return new DealCollection($business->deals()->paginate());
    }

    public function store(Request $request)
    {
        
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
