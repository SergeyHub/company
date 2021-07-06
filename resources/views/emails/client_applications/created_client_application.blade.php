@component('mail::message')
# New Client Application

@if($application->meeting_date)
<b>Meeting date:</b> <i>{{ $application->meeting_date }}</i><br>
@endif
<b>Client name:</b> <i>{{ $application->client != null ? $application->client->name: '' }}</i><br>
@if($application->phone)
<b>Client phone:</b> <i>{{ $application->phone }}</i>
@if($application->recall == true)
(Wants to recall)
@endif
<br>
@endif
<b>Girl:</b> <i>{{ $application->girl->name }} (id{{ $application->girl->id }})</i><br>
<b>Message: </b><br>
{{ $application->content }}
@endcomponent
