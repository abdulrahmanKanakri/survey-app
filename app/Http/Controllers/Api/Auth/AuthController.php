<?php

namespace App\Http\Controllers\Api\Auth;

use App\Classes\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User\Standard;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh']]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return ApiResponse::error([
                'errors' => $validator->errors(),
                'user' => $request->all()
            ]);
        }
        
        $user = new Standard;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number ?? null;
        $user->password = Hash::make($request->password);
        $user->save();
        $token = auth('api')->login($user);

        return ApiResponse::success([
            'user' => $user,
            'token' => $token
        ], 'Successfully registered');
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return ApiResponse::error([
                'credentials' => $credentials,
                'error' => 'Unauthorized'
            ], 'Invalid credentials', 401);
        }
        return $this->respondWithToken($token, 'Successfully logged in');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return ApiResponse::success(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return ApiResponse::success(null, 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh(), 'Successfully refreshed');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $msg = 'success')
    {
        return ApiResponse::success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], $msg);
    }

    private function validator($data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone_number' => ['nullable', 'string', 'min:10', 'max:10'],
        ]);
    }
}
