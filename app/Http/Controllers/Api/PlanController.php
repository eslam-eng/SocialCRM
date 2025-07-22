<?php

namespace App\Http\Controllers\Api;

use App\DTOs\PlanDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Http\Resources\Api\SuperAdmin\PlanResource;
use App\Services\Plan\PlanService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlanController extends Controller
{
    public function __construct(protected PlanService $planService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->get('filters');
        $withRelations = ['limitFeatures', 'addonFeatures'];
        $plans = $this->planService->paginate(filters: $filters, withRelation: $withRelations);

        return PlanResource::collection($plans);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanRequest $request)
    {
        $planDTO = PlanDTO::fromRequest($request);
        $plan = $this->planService->create(planDTO: $planDTO);

        return PlanResource::make($plan->loadMissing(['limitFeatures', 'addonFeatures']));

    }

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
        try {
            $this->planService->delete($id);

            return ApiResponse::success(message: 'Plan deleted successfully');
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Plan not found');
        }
    }
}
