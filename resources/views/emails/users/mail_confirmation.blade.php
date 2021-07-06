@component('mail::message')
# Confirm your email

@component('mail::button', ['url' => url('/verify/' . $user->email_verify_token)])
Verify Email
@endcomponent

<i>Let us know if you have problems using the site.</i><br>
<i>Write all questions in a return letter.</i>
@endcomponent
