@extends('layouts.app')

@section('content')

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3>Supportartiklar</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<posts-tech 
			:items="{{ $posts }}" 
			:fields="{{ $fields }}"
		>
		</posts-tech>
	</div>
</div>

@endsection

