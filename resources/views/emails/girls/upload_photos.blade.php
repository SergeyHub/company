@component('mail::message')
# Did you want to sell?

You forgot to upload your photos.<br>
Please sign in and upload your photos to receive purchase offers from men.

@component('mail::button', ['url' => url('/profile')])
Upload photos
@endcomponent

@component('mail::panel')
Your photos will only see the site administrators.<br>
Your confidential data will only see the site administration.<br>
@endcomponent

<i>Let us know if you have problems using the site.</i><br>
<i>Write all questions in a return letter.</i>
@endcomponent
