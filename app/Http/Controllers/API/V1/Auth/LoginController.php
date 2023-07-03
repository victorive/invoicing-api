<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $loginRequest)
    {
        $email = $loginRequest->validated('email');
        $password = $loginRequest->validated('password');

        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password, please try again'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = Auth::user();

        if ($user instanceof User) {

            $user->tokens()->delete();
            $token = $user->createToken('token')->plainTextToken;
        }

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
        ], Response::HTTP_OK)->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ]);
    }
}
