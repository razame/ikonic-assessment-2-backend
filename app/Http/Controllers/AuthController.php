<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    /**
     * Registration
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $token = $user->createToken('user')->plainTextToken;
            //Mail::to($user->email)->send(new VerifyEmail($user));
            return response()->json(['user' => $user, 'token' => $token]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 409);
        }
    }

    /**
     * Login
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if (!auth()->attempt($data)) {
                return response()->json(['error' => 'Invalid email or password'], 401);
            }

            $user = auth()->user();

            $token = $user->createToken('user')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token]);
        }
        catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


}
