<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AuthUserResource;
use App\Services\User\UserService;

class UserController extends Controller
{
    public function __construct(protected readonly UserService $userService) {}

    public function profile()
    {
        $user = auth()->user();
//        $token = "5|3AqSl92dwZLtPUUrTRZOzRjNDoh8QL5FEGERLMdEc0d643bd";
//        $redirectUrl = config('services.frontend_auth_redirect');
//
//        return redirect($redirectUrl)
//            ->withCookie(cookie('auth_token', $token, 60, null, null, true, true, false, 'Strict'));

        return ApiResponse::success(data: AuthUserResource::make($user));
    }
}
