@extends('layouts.app')

@section('content')

<div class="card">
	<div class="card-header h3">Hantera platser 
	</div>
	<div class="card-body">
		<ul style="list-style-type: none; padding: 0">
			@foreach ($locations as $location)
			@include('locations/links', ['location' => $location])
				<ul style="list-style-type: none">
					@foreach ($location->childrenLocations as $childLocation)
						@include('locations/child_location',['location' => $childLocation])
					@endforeach
				</ul>
			@endforeach
		</ul>
	</div>
</div>

@endsection
