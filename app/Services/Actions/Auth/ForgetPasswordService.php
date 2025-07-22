<?php

namespace App\Services\Actions\Auth;

use App\DTOs\RestPasswordDTO;
use App\Enum\VerificationCodeType;
use App\Models\User;
use App\Services\BaseService;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordService extends BaseService
{
    public function __construct(private readonly UserService $userService, private readonly VerificationCodeService $verificationCodeService) {}

    public function reset(ResetPasswordRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->findByKey('email', $request->email);
            if (! $user) {
                return ApiResponse::error(
                    message: 'User not found',
                    code: 404
                );
            }

            // Verify the code
            $this->verificationService->verifyCode(
                $user->email,
                'reset_password',
                $request->code
            );

            // Update password
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();

            return ApiResponse::success(
                message: 'Password has been reset successfully'
            );

        } catch (CodeNotFoundException|CodeExpiredException|MaxAttemptsExceededException $exception) {
            DB::rollBack();

            return ApiResponse::error(
                message: $exception->getMessage(),
                code: $exception->getCode()
            );
        }
    }

    /**
     * @throws \Throwable
     */
    public function restPassword(RestPasswordDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            $user = $this->userService->findByKey('email', $dto->email);
            // Verify the code
            $this->verificationCodeService->verifyCode(
                email: $user->email,
                type: VerificationCodeType::RESET_PASSWORD->value,
                code: $dto->code
            );
            // Update password
            $user->password = Hash::make($dto->password);

            return $user->save();
        });

    }

    protected function getFilterClass(): ?string
    {
        return null;
    }

    protected function baseQuery(): Builder
    {
        return User::query();
    }
}
