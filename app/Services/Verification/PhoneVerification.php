<?php

namespace App\Services\Verification;

use App\Entity\User\User;
use App\Entity\Verification\PhoneActivate;
use App\Services\Sms\SmsSender;
use App\Services\Verification\Exceptions\AlreadyVerifiedException;
use App\Services\Verification\Exceptions\ExpiredException;
use App\Services\Verification\Exceptions\LimitException;
use App\Services\Verification\Exceptions\VerificationException;

class PhoneVerification
{

    private $sender;

    public function __construct(SmsSender $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param User $user
     * @param string $phone
     * @return bool
     * @throws AlreadyVerifiedException
     */
    public function sendSms(User $user, string $phone)
    {
        PhoneActivate::where('phone', '!=', $phone)
            ->where('user_id', $user->id)
            ->delete();

        $activate_model = PhoneActivate::where('user_id', $user->id)
            ->where('phone', $phone)
            ->first();

        if (!$activate_model) {
            $activate_model = new PhoneActivate;
            $activate_model->user_id = $user->id;
        }

        if($activate_model->success)
            throw new AlreadyVerifiedException();

        $code = random_int(10000, 99999);
        $activate_model->tries = 0;
        $activate_model->phone = $phone;
        $activate_model->code = $code;
        $activate_model->expires_at = time() + 60*10;
        $activate_model->save();

        $this->sender->send($phone, 'One Night. Your code: '.$code);
        return true;
    }

    /**
     * @param User $user
     * @param string $code
     * @return bool
     * @throws ExpiredException
     * @throws VerificationException
     * @throws LimitException
     */
    public function verify(User $user, string $code)
    {
        $activate_model = PhoneActivate::where('user_id', $user->id)
            ->where('success', 0)
            ->first();

        if (!$activate_model)
            throw new VerificationException();
        if($activate_model->expires_at < time())
            throw new ExpiredException();
        if($activate_model->tries > 5)
            throw new LimitException();
        if ($activate_model->code !== $code) {
            $activate_model->tries++;
            $activate_model->save();
            return false;
        }
        $activate_model->success = true;
        $activate_model->save();
        return true;
    }

}
