@extends('layouts.app')

@include('menues.documents')

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
		<table class="table table-sm">
			<thead class="thead-light">
				<tr>
					<th class="d-none d-lg-table-cell">produkt</th>
					<th class="d-none d-lg-table-cell">benämning</th>
					<th class="d-none d-lg-table-cell">status</th>
					<th class="d-none d-lg-table-cell">plats</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($products as $product)
				<tr class="table-row">
					<td class="d-lg-table-cell">
                        {{ $product->product->item }}</a></td>
                    <td class="d-none d-lg-table-cell">
					    {{ $product->product->item_description_swe }}</td>
					<td class="d-none d-lg-table-cell">
					    {{ $product->status->description }}</td>
					<td class="d-none d-lg-table-cell">
					    {{ $product->location->name }}</td>				
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
	
@endsection
