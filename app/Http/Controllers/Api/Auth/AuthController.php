<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\AuthCredentialsDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthFormRequest;
use App\Http\Resources\Api\AuthUserResource;
use App\Services\Actions\Auth\AuthService;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthController extends Controller
{
    public function __invoke(AuthFormRequest $request, AuthService $authService)
    {
        try {
            $credentials = AuthCredentialsDTO::fromRequest($request);
            $user = $authService->authenticate($credentials);
            $token = $user->generateToken();

            $data = [
                'token' => $token,
                'user' => AuthUserResource::make($user),
            ];

            return ApiResponse::success(data: $data);
        } catch (UnauthorizedHttpException $e) {
            return ApiResponse::unauthorized(__('auth.failed'), []);
        }
    }
}
