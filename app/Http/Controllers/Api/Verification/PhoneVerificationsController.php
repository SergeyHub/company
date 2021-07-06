<?php

namespace App\Http\Controllers\Api\Verification;

use App\Http\Requests\Verification\SendSmsRequest;
use App\Http\Requests\Verification\SendVerifyRequest;
use App\Services\Verification\Exceptions\AlreadyVerifiedException;
use App\Services\Verification\Exceptions\ExpiredException;
use App\Services\Verification\Exceptions\LimitException;
use App\Services\Verification\Exceptions\VerificationException;
use App\Services\Verification\PhoneVerification;
use App\Http\Controllers\Controller;
use Twilio\Exceptions\TwilioException;

class PhoneVerificationsController extends Controller
{

    private $phoneVerification;

    public function __construct(PhoneVerification $phoneVerification)
    {
        $this->phoneVerification = $phoneVerification;
    }

    public function send(SendSmsRequest $request)
    {
        try {
            $result = $this->phoneVerification->sendSms(
                $request->user(),
                $request->get('phone')
            );
            return response()->json(['success' => $result]);
        } catch (AlreadyVerifiedException $verificationException) {
            return response()->json([
                'success' => true,
                'already_verified' => true
            ]);
        } catch (TwilioException $exception) {
            return response()->json([
                'success' => false,
                'error' => 'Not valid number'
            ]);
        }
    }

    public function verify(SendVerifyRequest $request)
    {
        try {
            $result = $this->phoneVerification->verify(
                $request->user(),
                $request->get('code')
            );
            return response()->json(['success' => $result]);
        } catch (VerificationException $exception) {
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage()
            ]);
        } catch (ExpiredException $exception) {
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage()
            ]);
        } catch (LimitException $exception) {
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage()
            ]);
        }
    }

}
