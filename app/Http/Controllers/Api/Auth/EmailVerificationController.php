<?php

namespace App\Http\Controllers\Api\Auth;

use App\Exceptions\VerificationCode\CodeExpiredException;
use App\Exceptions\VerificationCode\CodeNotFoundException;
use App\Exceptions\VerificationCode\MaxAttemptsExceededException;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyEmailRequest;
use App\Services\Actions\Auth\VerificationCodeService;
use App\Services\User\UserService;

class EmailVerificationController extends Controller
{
    public function __construct(
        private readonly VerificationCodeService $verificationService,
        private readonly UserService $userService
    ) {}

    public function verify(VerifyEmailRequest $request)
    {
        try {
            $user = $this->userService->getQuery()->withoutGlobalScope('tenant')->firstWhere('email', $request->email);
            if (! $user) {
                return ApiResponse::error(
                    message: 'email not found',
                    code: 404
                );
            }

            if (!$user->email_verified_at) {
                $this->verificationService->verifyCode($user->email, 'email_verification', $request->code);

                $user->email_verified_at = now();

                $user->save();
            }

            return ApiResponse::success(
                message: 'Email verified successfully'
            );

        } catch (CodeNotFoundException|CodeExpiredException|MaxAttemptsExceededException $exception) {
            return ApiResponse::error(message: $exception->getMessage(), code: $exception->getCode());
        }

    }
}
