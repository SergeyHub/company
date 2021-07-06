<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendPasswordResetLinkRequest;
use App\Http\Resources\Users\UserResource;
use App\Services\Users\PasswordService;
use App\Services\Users\UserService;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\AuthByResetTokenRequest;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    protected $passwordService;
    protected $userService;

    public function __construct(PasswordService $passwordService, UserService $userService) {
        $this->passwordService = $passwordService;
        $this->userService = $userService;
    }

    /**
     * @param SendPasswordResetLinkRequest $request
     * @return array
     */
    public function sendResetLink(SendPasswordResetLinkRequest $request) {
        $user = $this->userService->findByQuery(['email' => $request->email]);
        $result = $this->passwordService->sendPasswordResetLink($user);

        return ['success' => $result];
    }

    /**
     * @param AuthByResetTokenRequest $request
     * @return UserResource
     */
    public function authByResetToken(AuthByResetTokenRequest $request) {
        $user = $this->userService->findByQuery(['email' => $request->email]);
        if(!$this->passwordService->hasToken($user, $request->resetToken)) {
            return abort(403, 'Token not found or expired. Try again');
        }
        $this->passwordService->deleteToken($user);

        $authToken = $user->createToken('Application')->accessToken;

        return new UserResource($user, $authToken);
    }

    /**
     * @param ResetPasswordRequest $request
     * @return array
     */
    public function passwordReset(ResetPasswordRequest $request) {
        $result = $this->passwordService->resetPassword($request->user(), $request->getDto());

        return ['success' => $result];
    }
}
