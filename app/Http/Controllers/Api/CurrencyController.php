<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CurrencyDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CurrencyRequest;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CurrencyController extends Controller
{
    public function __construct(private CurrencyService $currencyService) {}

    public function index(Request $request)
    {
        $currencies = $this->currencyService->all($request->all());

        return response()->json($currencies);
    }

    public function show($id)
    {
        $currency = $this->currencyService->findById($id);
        if (! $currency) {
            return response()->json(['message' => 'Currency not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($currency);
    }

    public function store(CurrencyRequest $request)
    {
        $dto = CurrencyDTO::fromRequest($request);
        $this->currencyService->create($dto);

        return ApiResponse::success(message: 'currency created successfully');
    }

    public function update(CurrencyRequest $request, $id)
    {
        try {
            $dto = CurrencyDTO::fromRequest($request);
            $currency = $this->currencyService->update($id, $dto);

            return ApiResponse::success(message: 'currency updated successfully');
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Currency not found');
        }

    }

    public function destroy($id)
    {
        try {
            $deleted = $this->currencyService->delete($id);

            return ApiResponse::success(message: 'Currency deleted successfully');
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Currency not found');
        }

    }
}
