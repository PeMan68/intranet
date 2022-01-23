@extends('layouts.app')

@section('content')

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3>Produkter</h3>
			</div>
			<div class="col-6">

				<span class="text-right">
					@include('partials._productsform')
				</span>
			</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<products-table 
			:items="{{ $products }}" 
			:fields="{{ $fields }}"
			>
		</products-table>
	</div>
</div>

@endsection