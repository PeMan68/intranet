@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3">Hantera status för demoprodukter 
					<a class="btn btn-outline-primary float-right" 
					href="{{ route('admin.productstatus.create') }}">Skapa ny</a>
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
						@foreach($statuses as $status)
						<tr>
							<td>
							<a href="{{ route('admin.productstatus.edit', $status->id) }}">{{ $status->id }}</a>
							</td>
							<td>{{ $status->description }}</td>
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
