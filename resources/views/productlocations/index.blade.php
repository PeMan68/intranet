@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3">Hantera platser för demoprodukter 
					<a class="btn btn-outline-primary float-right" 
					href="{{ route('productlocations.create') }}">Skapa ny</a>
				</div>
                <div class="card-body">
					
					<table class="table">
					  <thead>
						<tr>
						  <th scope="col">ID</th>
						  <th scope="col">Beskrivning</th>
						</tr>
					  </thead>
					  <tbody>
						@foreach($locations as $location)
						<tr>
							<td>
							<a href="{{ route('productlocations.edit', $location->id) }}">{{ $location->id }}</a>
							</td>
							<td>{{ $location->description }}</td>
						</tr>
						@endforeach
					  </tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
