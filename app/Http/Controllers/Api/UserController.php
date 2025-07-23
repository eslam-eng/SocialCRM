<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AuthUserResource;
use App\Services\User\UserService;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function __construct(protected readonly UserService $userService) {}

    public function profile()
    {
        $user = auth()->user();
        return ApiResponse::success(data: AuthUserResource::make($user));
    }
}
