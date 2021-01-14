@extends('../layouts.emailToStaff')

@section('header')
Orsak till uppdatering: 
@if ($type=='comment')
Ny kommentar i ärendet
@else
Uppdaterad information om ärendet
@endif
<hr>

@endsection

@section('links')
|   
<a href="{{ route('issues.unfollow', $issue->id) }}">Sluta följa</a>
|
@endsection