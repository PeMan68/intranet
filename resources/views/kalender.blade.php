@extends('layouts.app')

@section('content')

<div class="calendar">
		@for($y=0;$y<=10;$y++)
			@for ($x=0;$x<=14;$x++)
				<div class="calendar-item"> 
					@if($y==0 and $x<>0) 
						<div class="dates">{{ $y * $x }}</div>
					@elseif($y<>0 and $x==0)
						<div class="names">Namn</div>
					@elseif($y==2 and $x==4)
						<div class="activity" style="background-color: red;">&nbsp;</div>
						<div class="activity" style="background-color: blue;">&nbsp;</div>
					@else
						<div>&nbsp;</div>
					@endif
				</div>
			@endfor
		@endfor
</div>

@endsection
