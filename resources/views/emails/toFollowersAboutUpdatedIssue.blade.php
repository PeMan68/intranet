@extends('../layouts.emailToStaff')

@section('header')
Uppdaterad information
<hr>

@endsection

@section('links')
|   
<a href="{{ route('issues.unfollow', $issue->id) }}">Sluta följa</a>
|
@endsection