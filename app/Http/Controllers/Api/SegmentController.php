<?php

namespace App\Http\Controllers\Api;

use App\DTOs\SegmentDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SegmentRequest;
use App\Http\Resources\Api\SegmentResource;
use App\Services\SegmentService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SegmentController extends Controller
{
    public function __construct(private SegmentService $segmentService) {}

    public function index(Request $request)
    {
        $segments = $this->segmentService->paginate($request->all());

        return SegmentResource::collection($segments);
    }

    public function store(SegmentRequest $request)
    {
        $dto = SegmentDTO::fromRequest($request);
        $segment = $this->segmentService->create($dto);

        return SegmentResource::make($segment);
    }

    public function update(SegmentRequest $request, $id)
    {
        try {
            $dto = SegmentDTO::fromRequest($request);
            $segment = $this->segmentService->update($id, $dto);

            return ApiResponse::success(message: 'currency updated successfully');
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Currency not found');
        }

    }

    public function destroy($id)
    {
        try {
            $this->segmentService->delete($id);

            return ApiResponse::success(message: 'Segment deleted successfully');
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Segment not found');
        }

    }
}
