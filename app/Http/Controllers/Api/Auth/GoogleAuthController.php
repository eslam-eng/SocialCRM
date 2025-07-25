<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enum\AvailableSocialProvidersEnum;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AuthUserResource;
use App\Services\Actions\Auth\SocialAuthService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function __construct(protected readonly SocialAuthService $socialAuthService)
    {
    }

    public function redirectToProvider(string $provider = 'google')
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return ApiResponse::success(data: ['url' => $url]);
    }

    public function authenticate(Request $request)
    {
        try {

            if ($request->get('access_token') == null || $request->get('access_token') == "") {
                return ApiResponse::badRequest(message: 'Access token is missing');
            }

            $user = $this->socialAuthService->handle(provider_name: AvailableSocialProvidersEnum::GOOGLE->value, access_token: $request->access_token);

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
