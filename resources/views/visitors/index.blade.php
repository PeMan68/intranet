@extends('layouts.app')

@include('menues.visitors')

@section('content')
<div class="card">
	<div class="card-header justify-content-between h3">
		Lista besökare
	</div>
	<div class="card-body">
		@foreach ($visitors as $visitor)
		<li>
			<a href="{{ route('visitors.edit', $visitor->id) }}">
				{{ date('Y-m-d H:i', strtotime($visitor->startTime)) . ', ' . $visitor->company}}
			</a>
		</li>
		@endforeach
	<footer class="blockquote-footer">Besökare raderas automatiskt när 30 dagar passerat</footer>
	</div>
</div>
@endsection
