<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AdminAuthController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw new UnauthorizedHttpException('', __('auth.failed'));
        }

        $token = $admin->createToken('admin_token')->plainTextToken;
        $data = [
            'admin' => $admin,
            'token' => $token,
        ];
        return ApiResponse::success(data: $data);
    }
}
