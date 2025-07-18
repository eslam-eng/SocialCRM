<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\AuthCredentialsDTO;
use App\Helpers\ApiResponse;
use App\Http\Requests\Api\AuthFormRequest;
use App\Services\Actions\Auth\AdminAuthService;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AdminAuthController
{
    public function __invoke(AuthFormRequest $request, AdminAuthService $authService)
    {
        try {
            $credentials = AuthCredentialsDTO::fromRequest($request);
            $admin = $authService->authenticate($credentials);
            $token = $admin->generateToken();
            $data = [
                'user' => $admin,
                'token' => $token,
            ];

            return ApiResponse::success(data: $data);
        } catch (UnauthorizedHttpException $e) {
            return ApiResponse::unauthorized(__('auth.failed'), []);
        }
    }
}
