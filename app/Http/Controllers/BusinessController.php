<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;
use App\Http\Resources\BusinessResource;

class BusinessController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Business $business)
    {
        return new BusinessResource($business);
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
