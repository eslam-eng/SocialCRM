<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTOs\FeatureDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Feature\StoreFeatureRequest;
use App\Http\Requests\Feature\UpdateFeatureRequest;
use App\Http\Resources\Api\SuperAdmin\FeatureResource;
use App\Http\Resources\Api\SuperAdmin\TenantResource;
use App\Services\Admin\Tenant\TenantService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TenantController extends Controller
{
    public function __construct(private readonly TenantService $tenantService)
    {
    }

    public function index(Request $request)
    {
        $tenants = $this->tenantService->paginate(filters: $request->all());

        return TenantResource::collection($tenants);
    }

    public function statics()
    {
        $statics = $this->tenantService->statics();
        return ApiResponse::success(data: $statics);
    }

    public function store(StoreFeatureRequest $request)
    {
        $dto = FeatureDTO::fromRequest($request);

        $feature = $this->featureService->create(dto: $dto);

        return FeatureResource::make($feature);
    }

    public function update(UpdateFeatureRequest $request, $id)
    {
        try {
            $dto = FeatureDTO::fromRequest($request);

            $feature = $this->featureService->update(id: $id, dto: $dto);

            return ApiResponse::success(message: 'Feature updated successfully');
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Feature not found');
        }

    }

    public function destroy($id)
    {
        try {
            $this->featureService->delete($id);

            return ApiResponse::success(message: 'Feature deleted successfully from all plans');
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Feature not found');
        }

    }
}
