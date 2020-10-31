@extends('layouts.app')

@section('content')

<div class="card">
	<div class="card-header h3">Hantera platser 
	</div>
	<div class="card-body">
		<a class="btn btn-small btn-outline-primary" 
		href="{{ route('locations.create', '') }}">
		<i class="material-icons black">house</i> Ny byggnad</a>
		<ul style="list-style-type: none; padding: 0">
			@foreach ($locations as $location)
				<li>
					<a 	href="{{ route('locations.create', $location->id) }}">[+]</a>
					{{ $location->name }}
				</li>
				<ul style="list-style-type: none">
					@foreach ($location->childrenLocations as $childLocation)
						@include('locations/child_location',['child_location' => $childLocation])
					@endforeach
				</ul>
			@endforeach
		</ul>
	</div>
</div>

@endsection
