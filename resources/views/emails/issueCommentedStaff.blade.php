@extends('../layouts.emailToStaff')

@section('header')
Ny kommentar i ärendet
<hr>

@endsection

@section('links')
|   
<a href="{{ route('issues.unfollow', $issue->id) }}">Sluta följa</a>
|
@endsection