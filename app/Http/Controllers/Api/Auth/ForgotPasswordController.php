<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\RestPasswordDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestPasswordRequest;
use App\Http\Requests\SendRestCodeRequest;
use App\Services\Actions\Auth\ForgetPasswordService;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    public function __construct(protected readonly ForgetPasswordService $forgetPasswordService) {}

    public function sendResetCode(SendRestCodeRequest $request)
    {
        $this->forgetPasswordService->sendResetCode(email: $request->email);

        return ApiResponse::success(message: 'Reset code sent to your email, check your inbox');
    }

    public function resetPassword(RestPasswordRequest $request)
    {
        $restPasswordDTO = RestPasswordDTO::fromRequest($request);
        try {
            $this->forgetPasswordService->restPassword(dto: $restPasswordDTO);

            return ApiResponse::success(message: 'Password reset successful');

        } catch (ValidationException $exception) {
            return ApiResponse::validationErrors(message: $exception->getMessage(), errors: $exception->errors());
        }
    }
}
