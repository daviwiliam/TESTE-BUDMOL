<?php

namespace App\Services;

use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class UserService
{
    public function getUserFromToken($token)
    {
        $personalAccessToken = PersonalAccessToken::findToken($token);

        if (!$personalAccessToken) {
            return null;
        }

        $user = $personalAccessToken->tokenable;
        return User::find($user->id);
    }
}
