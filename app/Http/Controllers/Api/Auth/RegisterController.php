<?php

namespace App\Http\Controllers\Api\Auth;

use App\DTOs\UserDTO;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\Api\AuthUserResource;
use App\Services\Actions\Auth\RegisterService;
use App\Services\Actions\Auth\VerificationCodeService;
use Symfony\Component\Mailer\Exception\TransportException;

class RegisterController extends Controller
{
    /**
     * @throws \Throwable
     */
    public function __invoke(RegisterRequest $request, RegisterService $registerService, VerificationCodeService $verificationCodeService)
    {
        $user = null;
        try {
            $userDTO = UserDTO::fromRequest($request);

            $user = $registerService->handle(registerDTO: $userDTO);

            $verificationCodeService->sendVerificationCode(
                email: $user->email,
                type: 'email_verification',
                userName: $user->name
            );
            $user->fresh();
            $data = [
                'token' => $user->generateToken(),
                'user' => AuthUserResource::make($user),
            ];

            return ApiResponse::success(data: $data);
        } catch (TransportException $e) {
            //todo remove this when mail should queue
            $data = [
                'token' => $user->generateToken(),
                'user' => AuthUserResource::make($user),
            ];
            return ApiResponse::success(data: $data, message: 'Verification code sent to your mail, please check your email address');
        } catch (\Exception $e) {
            return ApiResponse::error(message: 'there is an error please try again later or contact with support for fast response');
        }
    }
}
