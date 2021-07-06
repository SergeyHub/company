<?php
namespace App\Services\Users;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Mail\Users\MailResetPasswordLink;
use App\Entity\User\User;
use App\Entity\User\PasswordReset;
use App\DTO\Users\ResetPasswordDto;
use Hash;

class PasswordService {
    /**
     * @param User $user
     * @return bool
     */
    public function sendPasswordResetLink(User $user) {
        $token = Password::createToken($user);

        $link = config('app.url') . '/password/reset?' . http_build_query([
                'token' => $token,
                'email' => $user->email
            ]);
        \Log::info('send_link' . $link);

        $this->sendEmail($user, $link);

        return true;
    }

    /**
     * @param User $user
     * @param string $token
     * @return bool
     */
    public function hasToken(User $user, string $token): bool {
        \Log::info('CHECKING TOKEN');
        \Log::info($token);
        \Log::info($user);
        \Log::info((integer) Password::tokenExists($user, $token));
        return Password::tokenExists($user, $token);
    }

    public function deleteToken(User $user) {
        return Password::deleteToken($user);
    }

    /**
     * @param User $user
     * @param ResetPasswordDto $dto
     * @return bool
     */
    public function resetPassword(User $user, ResetPasswordDto $dto): bool {
        if(Password::tokenExists($user, $dto->getToken())) {
            $user->password = Hash::make($dto->getPassword());
            $user->save();

            Password::deleteToken($user);
            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param string $link
     */
    private function sendEmail(User $user, string $link): void {
        Mail::to($user)
            ->later(1, (new MailResetPasswordLink($link))->onQueue('mail'));
    }

}
