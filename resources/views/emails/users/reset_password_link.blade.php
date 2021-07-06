@component('mail::message')
# Visit link below for reset your password

@component('mail::button', ['url' => url($passwordResetLink)])
Reset password
@endcomponent

<i>If you didn't request password reset, just ignore this message.</i><br>
<i>Please, don't reply to this message.</i>
@endcomponent
