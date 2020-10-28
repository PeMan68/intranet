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
					<th class="d-none d-lg-table-cell text-right">benämning</th>
					<th class="d-none d-lg-table-cell text-center">serienummer</th>
					<th class="d-none d-lg-table-cell">inköpt</th>
					<th class="d-none d-lg-table-cell">av</th>
					<th class="d-none d-lg-table-cell">beskrivning</th>
					<th class="d-none d-lg-table-cell"></th>
				</tr>
			</thead>
			<tbody>
			@foreach ($products as $product)
				<tr class="table-row">
					<td class="d-lg-table-cell">
					
                        {{ $product->product_id }}</a></td>
                        <td class="d-none d-lg-table-cell text-right">
					{{ $product->item_description_swe }}</td>
					<td class="d-none d-lg-table-cell text-center">
					{{ $product->version }}</td>
					<td class="d-none d-lg-table-cell">
					{{ $product->invoice_date }}</td>
					
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
	
@endsection
