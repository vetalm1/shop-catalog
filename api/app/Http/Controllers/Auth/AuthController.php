<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckPhoneRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SendCodeRequest;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\BindingService;
use App\Services\SmsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $success = false;

        if (VerificationCode::verify($request->phone, $request->code)) {
            $user = User::where('phone', $request->phone)->first();

            if (!$user) {
                $user = User::create([
                    'phone' => $request->input('phone'),
                    'phone_verified_at' => Carbon::now(),
                    'password' => Hash::make($request->code),
                ]);
            } else {
                $user->update(['password' => Hash::make($request->code)]);
            }

            Auth::login($user);
            $success = true;
        }

        return response()->json(['success' => $success]);
    }

    public function logout()
    {
        Auth::guard('web')->logout();

        Session::regenerate();

        return new JsonResponse();
    }
}
