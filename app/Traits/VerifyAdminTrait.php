<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait VerifyAdminTrait
{
    public function verifyAdmin($request)
    {
        if (!$request->user() || !$request->user()->admin)
        {    
            throw new HttpResponseException(response()->json([
                'message' => 'Unauthorized'
            ], 403));
        }
    }
}
