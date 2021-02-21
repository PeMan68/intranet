@extends('../layouts.emailToStaff')

@section('header')
    Nytt ärende
@endsection

@section('links')
|   
<a href="{{ route('issues.unfollow', $issue->id) }}">Sluta följa</a>
|
@endsection