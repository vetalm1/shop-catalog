<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VerificationCode extends Model
{
    protected $fillable = [
        'phone',
        'email',
        'code',
        'created_at',
    ];

    const TEST_CODE = '999999';

    public static function createByPhone(string $phone): VerificationCode
    {
        return VerificationCode::updateOrCreate(
            ['phone' => $phone],
            [
                'phone' => $phone,
                'code' => self::generateCode(),
                'created_at' => Carbon::now(),
            ]
        );
    }

    public static function createByEmail(string $email): VerificationCode
    {
        return VerificationCode::create([
            'email' => $email,
            'code' => self::generateCode(),
        ]);
    }

    public static function verify(string $phone, string $code): bool
    {
        $verification = VerificationCode
            ::where('phone', $phone)
            ->where('code', $code)
            ->where('created_at', '>', Carbon::now()->subMinutes(10))
            ->count();

        $user = User::where('phone', $phone)->first();

        if ($verification && $user) {
            $user->phone_verified_at = Carbon::now();
            $user->save();
        }

        return $verification;
    }

    public static function verifyEmail(string $email, string $code)
    {
        $verification = VerificationCode
            ::where('email', $email)
            ->where('code', $code)
            ->where('created_at', '>', Carbon::now()->subMinutes(30))
            ->count();

        if ($verification) {
            $user = User::where('email', $email)->firstOrFail();
            $user->email_verified_at = Carbon::now();
            $user->save();
        }

        return $verification;
    }

    private static function generateCode(): string
    {
        return (string)app()->isLocal() ? self::TEST_CODE : rand(111110, 999998);
    }
}
