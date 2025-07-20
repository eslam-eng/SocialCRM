<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Http\Resources\Api\PlanResource;
use App\Services\Plan\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(protected PlanService $planService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->get('filters');
        $withRelations = ['features'];
        $plans = $this->planService->paginate(filters: $filters, withRelation: $withRelations);

        return PlanResource::collection($plans);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
