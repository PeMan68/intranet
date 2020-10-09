@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3">Hantera platser 
					<a class="btn btn-outline-primary float-right" 
					href="{{ route('locations.create') }}">Skapa ny</a>
				</div>
                <div class="card-body">
					<ul>
						@foreach ($locations as $location)
							<li>{{ $location->name }}</li>
							<ul>
								@foreach ($location->childrenLocations as $childLocation)
									@include('locations/child_location',['child_location' => $childLocation])
								@endforeach
							</ul>
						@endforeach
					</ul>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
