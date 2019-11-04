@extends('layouts.reception')

@section('content')

	<p class="display-1 text-center">Välkommen till Carlo Gavazzi</p>
	<div class="card">
		<div class="card-header">Besökare {{ date('Y-m-d') }}</div>
	<ul>
	@foreach ($visitors as $visitor)
		<li>{{ $visitor->name }}, {{ $visitor->company }}</li>
	@endforeach
	</ul>
	</div>
</div>
@endsection