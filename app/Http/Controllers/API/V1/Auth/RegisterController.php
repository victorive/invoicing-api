<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\RegisterRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $registerRequest)
    {
        $user = User::query()->create($registerRequest->validated());

        return response()->json([
            'status' => true,
            'message' => 'Registration successful',
            'data' => $user
        ], Response::HTTP_CREATED);
    }
}
