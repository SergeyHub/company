<?php

namespace App\Http\Controllers\Api\Auth;

use App\Entity\User\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\Users\RegisterService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $registerService;

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(RegisterService $registerService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'emailVerifySend', 'emailVerify']]);
        $this->registerService = $registerService;
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = User::where('email', request('email'))->first();
        if (!$user->email_verified_at) {
            return response()->json(['error' => 'email_unverified', 'user_id' => $user->id], 401);
        }
        // генерируем токен
        $token = $user->createToken('Application')->accessToken;
        return new UserResource($user, $token);
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->registerService->register($request->getDto());
        return response()->json(['user_id' => $user->id]);
    }

    public function emailVerifySend($id)
    {
        $user = User::find($id);
        $result = false;
        if ($user && !$user->email_verified_at) {
            $result = $this->registerService->emailVerifySend($user);
        }
        return response()->json(['success' => $result]);
    }

    public function emailVerify($token)
    {
        $result = $this->registerService->emailVerify($token);
        return response()->json(['success' => $result]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return new UserResource(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $accessToken = auth()->user()->token();
        $accessToken->revoke();
        return response()->json(null, 204);
    }

}
