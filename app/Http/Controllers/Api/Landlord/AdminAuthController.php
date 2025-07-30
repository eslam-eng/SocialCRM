<?php

namespace App\Http\Controllers\Api\Landlord;

use App\DTOs\AuthCredentialsDTO;
use App\Helpers\ApiResponse;
use App\Http\Requests\AuthFormRequest;
use App\Http\Resources\Api\SuperAdmin\AuthUserResource;
use App\Services\Landlord\Actions\Auth\AdminAuthService;
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
                'user' => AuthUserResource::make($admin),
                'token' => $token,
            ];

            return ApiResponse::success(data: $data);
        } catch (UnauthorizedHttpException $e) {
            return ApiResponse::unauthorized(__('auth.failed'), []);
        }
    }
}
