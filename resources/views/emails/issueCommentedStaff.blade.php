@extends('../layouts.emailToStaff')

@section('header')
Ny kommentar i ärendet
<hr>
@if (is_null($issue->timeCustomercallback))
<span style='font-size: 0.8em; font-family: Verdana,Arial,sans-serif'>
	<b><i>
	Kunden har inte fått någon återkoppling ännu!<br><br>
	Om du kan, kontakta kunden för att ge en första feedback
	</i></b>
	<ul>
		<li>Öppna ärendet, kontrollera status för återkoppling</li>
		<li>Kontakta kunden för en första återkoppling</li>
		<li>Markera kunden som kontaktad</li>
	</ul>
	<hr>
</span>
@endif
@endsection

@section('links')
|   
<a href="{{ route('issues.unfollow', $issue->id) }}">Sluta följa</a>
|
@endsection