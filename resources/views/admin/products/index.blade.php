@extends('layouts.app')


@section('content')
<div class="row h5">
	<div class="col-sm-3">Artikel</div>
	<div class="col-sm-5">Beskrivning</div>
	<div class="col-sm-2">Listpris</div>
	<div class="col-sm-2">Importdatum</div>
</div>
<div class="row">
@foreach ($products as $product)
		<div class="col-sm-3">{{ $product->item }}</div>
		<div class="col-sm-5">{{ $product->item_description_swe}}</div>
		<div class="col-sm-2">{{ $product->listprice}}</div>
		<div class="col-sm-2">{{ $product->created_at}}</div>
@endforeach
{{ $products->links() }}
</div>
@endsection


