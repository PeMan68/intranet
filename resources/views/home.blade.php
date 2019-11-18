@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row pb-3">
		<div class="col">
			@include('partials._chart')
		</div>
	</div>
	<div class="row">
		<div class="col pb-3">
			@include('partials._kalender')
		</div>
	</div>
	<div class="row">
		<div class="col pb-3">
			@include('partials._visitors')
		</div>
	</div>
</div>

@endsection
