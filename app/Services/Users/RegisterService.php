<?php

namespace App\Services\Users;

use App\DTO\Users\UserCreateDto;
use App\Entity\Girl\Girl;
use App\Entity\User\User;
use App\Exceptions\ValidationException;
use App\Mail\Users\MailConfirmation;
use Carbon\Carbon;
use Illuminate\Bus\Dispatcher;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterService
{

    /** @var ValidatorInterface */
    private $validator;
    private $mailer;
    private $dispatcher;

    public function __construct(Mailer $mailer, Dispatcher $dispatcher)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
        $this->validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
    }

    /**
     * @param UserCreateDto $dto
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     * @throws ValidationException
     * @throws \Throwable
     */
    public function register(UserCreateDto $dto)
    {
        $violations = $this->validator->validate($dto);

        if(count($violations) > 0) {
            throw new ValidationException((string) $violations);
        }

        $user = User::where('email', $dto->getEmail())
            ->first();

        if($user)
            throw new ValidationException('Email already registered');

        $user = new User;
        $user->name = $dto->getName();
        $user->email = $dto->getEmail();
        $user->password = Hash::make($dto->getPassword());
        $user->role = $dto->getRole();
        $user->type = $dto->getType();
        $user->status = $dto->getStatus();
        $user->saveOrFail();

        // если регистрируется как клиент, то создаем профиль клиента
        if  ($user->type === User::TYPE_CLIENT) {
            $user->client()->create();
        }

        $this->emailVerifySend($user);

        return $user;
    }

    /**
     * @param User $user
     * @return boolean
     */
    public function emailVerifySend(User $user)
    {
        $user->email_verify_token = Str::random(32);
        $user->save();
        Mail::to($user)
            ->later(1, new MailConfirmation($user));
        return true;
    }

    /**
     * @param string $token
     * @return boolean
     */
    public function emailVerify($token)
    {
        if (!$user = User::where('email_verify_token', $token)->first()) {
            return false;
        }

        $user->email_verify_token = null;
        $user->email_verified_at = Carbon::now();
        $user->save();

        return true;
    }

}
