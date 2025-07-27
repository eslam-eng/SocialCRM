<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AuthUserResource;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(protected readonly UserService $userService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->all();

    }

    public function profile()
    {
        $user = auth()->user();
        return ApiResponse::success(data: AuthUserResource::make($user));
    }
}
