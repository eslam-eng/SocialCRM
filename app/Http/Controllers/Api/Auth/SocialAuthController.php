<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AuthUserResource;
use App\Services\Actions\Auth\SocialAuthService;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function __construct(protected readonly SocialAuthService $socialAuthService) {}

    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function authenticate(string $provider)
    {
        try {
            $user = $this->socialAuthService->handle(provider_name: $provider);

            $token = $user->generateToken();

            $data = [
                'token' => $token,
                'user' => AuthUserResource::make($user),
            ];

            return ApiResponse::success(data: $data);
        } catch (\Exception $e) {
            return ApiResponse::error(message: 'there is an error please try again later or contact with support for fast response');
        }
    }
}
