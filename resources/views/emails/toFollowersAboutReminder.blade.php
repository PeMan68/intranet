@extends('../layouts.emailToStaff')

@section('header')

@if ($type=='paused')
Ärendet är markerat som pausat. Dags att ta tag idet igen?
@elseif ($type=='waitingForInternal')
Ärendet är markerat att vi väntar på svar från <strong>kollega</strong>. Dags för en påminnelse?
@elseif ($type=='waitingForExternal')
Ärendet är markerat att vi väntar på svar från <strong>kunden</strong>. Dags för en påminnelse?
@endif
<hr>

@endsection

@section('links')
|   
<a href="{{ route('issues.unfollow', $issue->id) }}">Sluta följa</a>
|
@endsection