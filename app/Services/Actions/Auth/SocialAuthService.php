<?php

namespace App\Services\Actions\Auth;

use App\DTOs\UserDTO;
use App\Enum\AvailableSocialProvidersEnum;
use App\Models\SocialAccount;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

readonly class SocialAuthService
{
    public function __construct(protected RegisterService $registerService) {}

    /**
     * Attempt to login with credentials and return user or unauthorized exception.
     *
     * @throws UnauthorizedHttpException
     */
    public function handle(string $provider_name): User
    {
        // check that provider name in available providers
        if (! in_array($provider_name, AvailableSocialProvidersEnum::values())) {
            throw new BadRequestHttpException('Provider not found');
        }

        $oauthUser = Socialite::driver($provider_name)->stateless()->user();
        $socialAccount = SocialAccount::where('provider_name', $provider_name)
            ->where('provider_id', $oauthUser->getId())
            ->first();
        if ($socialAccount) {
            return $socialAccount->user;
        }

        // You can either create or link to an existing user based on email
        $email = $oauthUser->getEmail();
        $name = $oauthUser->getName();

        $userDTO = new UserDTO(name: $name, organization_name: $name, email: $email);
        // check if user exists before with same email
        $user = User::query()->firstWhere('email', value: $email);
        if (! $user) {
            $user = $this->registerService->handle($userDTO);
        }

        $user->socialAccounts()->create([
            'provider_name' => $provider_name,
            'provider_id' => $oauthUser->getId(),
            'access_token' => encrypt($oauthUser->token),
            'refresh_token' => encrypt($oauthUser->refreshToken ?? ''),
            'expires_in' => $oauthUser->expiresIn,
            'avatar' => $oauthUser->getAvatar(),
        ]);

        return $user;
    }
}
