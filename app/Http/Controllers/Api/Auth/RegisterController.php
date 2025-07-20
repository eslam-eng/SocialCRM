<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\UserDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\Api\AuthUserResource;
use App\Services\Actions\Auth\RegisterService;

class RegisterController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function __invoke(RegisterRequest $request, RegisterService $registerService)
    {
        try {
            $userDTO = UserDTO::fromRequest($request);

            $user = $registerService->handle(registerDTO: $userDTO);

            $data = [
                'token' => $user->generateToken(),
                'user' => AuthUserResource::make($user),
            ];
            return ApiResponse::success(data: $data);
        } catch (\Exception $e) {
            return ApiResponse::error(message: 'there is an error please try again later or contact with support for fast response');
        }
    }
}
