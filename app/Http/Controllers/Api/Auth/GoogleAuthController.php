<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enum\AvailableSocialProvidersEnum;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\Actions\Auth\SocialAuthService;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function __construct(protected readonly SocialAuthService $socialAuthService) {}

    public function redirectToProvider(string $provider = 'google')
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return ApiResponse::success(data: ['url' => $url]);
    }

    public function authenticate(Request $request)
    {
        try {

            $user = $this->socialAuthService->handle(provider_name: AvailableSocialProvidersEnum::GOOGLE->value);

            $redirectUrl = config('services.frontend_auth_redirect');

            $token = $user->generateToken();

            return redirect($redirectUrl)
                ->withCookie(cookie('auth_token', $token, 60, null, null, true, true, false, 'Strict'));
        } catch (\Exception $e) {
            logger($e);

            return ApiResponse::error(message: 'there is an error please try again later or contact with support for fast response');
        }
    }
}
