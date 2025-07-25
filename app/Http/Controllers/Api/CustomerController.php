<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CustomerDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\Api\CustomerResource;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomerController extends Controller
{
    public function __construct(protected readonly CustomerService $customerService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = array_filter([
            'name' => $request->name ?? null,
            'status' => $request->status ?? null,
        ], fn($value) => !is_null($value) && $value !== '');

        $customers = $this->customerService->paginate($filters);

        return CustomerResource::collection($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $customerDTO = CustomerDTO::fromRequest($request);
        $customer = $this->customerService->create($customerDTO);

        return ApiResponse::success(data: CustomerResource::make($customer), message: __('app.customer_created_successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $customer = $this->customerService->findById($id);
            return ApiResponse::success(data: CustomerResource::make($customer));
        } catch (NotFoundHttpException $exception) {
            return ApiResponse::notFound(message: $exception->getMessage());
        }
    }


    public function statics()
    {
        $statics = $this->customerService->statics();
        return ApiResponse::success(data: $statics);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, string $id)
    {
        try {
            $customerDTO = CustomerDTO::fromRequest($request);
            $customer = $this->customerService->update(id: $id, customerDTO: $customerDTO);
            return ApiResponse::success(data: CustomerResource::make($customer), message: __('app.customer_updated_successfully'));
        } catch (NotFoundHttpException $exception) {
            return ApiResponse::notFound(message: $exception->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->customerService->delete($id);

            return ApiResponse::success(message: 'Customer deleted successfully');
        } catch (NotFoundHttpException $e) {
            return ApiResponse::notFound(message: 'Customer not found');
        }
    }
}
