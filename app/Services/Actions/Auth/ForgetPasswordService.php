<?php

namespace App\Services\Actions\Auth;

use App\DTOs\RestPasswordDTO;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ForgetPasswordService extends BaseService
{
    public function sendResetCode(string $email)
    {
        $code = rand(100000, 999999);

        Cache::put('reset_code_'.$email, $code, now()->addMinutes(15));

        Mail::raw("Your reset code is: $code", fn ($message) => $message->to($email)->subject('Password Reset Code'));

        return true;
    }

    public function restPassword(RestPasswordDTO $dto)
    {
        $cachedCode = Cache::get('reset_code_'.$dto->email);

        if ($cachedCode != $dto->code) {
            throw ValidationException::withMessages([
                'code' => ['The provided code is invalid.'],
            ]);
        }

        $user = $this->getQuery()->firstWhere('email', $dto->email);

        $user->password = Hash::make($dto->password);

        $user->save();

        Cache::forget('reset_code_'.$dto->email);
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
