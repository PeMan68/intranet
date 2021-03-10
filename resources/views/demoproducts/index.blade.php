@extends('layouts.app')

{{-- @include('menues.demoproducts') --}}

@section('content')

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3>Demoprodukter</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<demoproducts-table 
			:items="{{ $products }}" 
			:fields="{{ $fields }}" 
			{{-- filter="{{ $filter }}" --}}
			>
		</demoproducts-table>
	</div>
</div>

@endsection
