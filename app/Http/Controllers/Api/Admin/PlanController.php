<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTOs\PlanDTO;
use App\Enum\SubscriptionDurationEnum;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Http\Resources\Api\SuperAdmin\PlanResource;
use App\Services\Admin\Plan\PlanService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlanController extends Controller
{
    public function __construct(protected PlanService $planService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'billing_cycle' => $request->query('billing_cycle', SubscriptionDurationEnum::MONTHLY->value),
            'is_active' => $request->query('is_active', true),
        ];

        $withRelations = ['limitFeatures', 'addonFeatures'];

        $plans = $this->planService->paginate(filters: array_filter($filters), withRelation: $withRelations);

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
    public function update(PlanRequest $request, string $id)
    {
        try {
            $planDTO = PlanDTO::fromRequest($request);
            $plan = $this->planService->update(planDTO: $planDTO, plan: $id);
            return ApiResponse::success(data: PlanResource::make($plan->loadMissing(['limitFeatures', 'addonFeatures'])), message: __('app.plan_updated_successfully'));
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Plan not found');
        }


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
