<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;
use App\Http\Resources\BusinessResource;
use App\Http\Requests\BusinessRequest;

class BusinessController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Business::class, 'business');
    }

    public function store(BusinessRequest $request)
    {
        $business = Business::createForUser(auth()->user()->id, $request);

        return new BusinessResource($business);
    }

    public function show(Business $business)
    {
        return new BusinessResource($business);
    }

    public function update(BusinessRequest $request, Business $business)
    {
        $business->update($request->all());

        return new BusinessResource($business);
    }

    public function destroy(BusinessRequest $request, Business $business)
    {
        $business->delete();
        
        return response(null, 204);
    }
}
