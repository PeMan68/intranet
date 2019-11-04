@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header justify-content-between">
						<span>Lista besökare</span>
							<a class="btn btn-outline-primary" href="{{ route('visitors.create') }}">
									Registrera ny besökare
							</a>
					
				</div>
                <div class="card-body">
					@foreach ($visitors as $visitor)
					<li>
						<a href="{{ route('visitors.edit', $visitor->id) }}">
							{{ $visitor->start . ', ' . $visitor->name . ', ' . $visitor->company}}
						</a>
					</li>
					@endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
