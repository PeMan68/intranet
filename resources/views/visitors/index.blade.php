@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lista besökare
                    <a href="{{ route('visitors.create') }}">
						<button type="submit" class="btn btn-primary">
							Registrera ny besökare
						</button>
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
