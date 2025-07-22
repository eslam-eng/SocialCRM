<?php

namespace App\Http\Controllers\Api;

use App\DTOs\FeatureDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Feature\StoreFeatureRequest;
use App\Http\Requests\Feature\UpdateFeatureRequest;
use App\Http\Resources\Api\FeatureResource;
use App\Services\FeatureService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FeatureController extends Controller
{
    public function __construct(private readonly FeatureService $featureService) {}

    public function index(Request $request)
    {
        $features = $this->featureService->paginate(filters: $request->all());

        return FeatureResource::collection($features);
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

            return ApiResponse::success(message: 'Feature deleted successfully');
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Feature not found');
        }

    }
}
