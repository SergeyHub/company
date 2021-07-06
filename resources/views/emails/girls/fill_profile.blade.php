@component('mail::message')
# Did you want to sell?

You forgot to fill your profile.<br>
Please sign in and fill out your profile to receive purchase offers from men.

@component('mail::button', ['url' => url('/profile')])
Fill profile
@endcomponent

<i>Let us know if you have problems using the site.</i><br>
<i>Write all questions in a return letter.</i>
@endcomponent
