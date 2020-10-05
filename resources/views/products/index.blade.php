@extends('layouts.app')


@section('content')

@foreach ($products as $product)
		<div class="col-sm-3">{{ $product->item }}</div>
		<div class="col-sm-5">{{ $product->item_description}}</div>
		<div class="col-sm-2">{{ $product->listprice}}</div>
		<div class="col-sm-2">{{ $product->created_at}}</div>
@endforeach
{{ $products->links() }}
@endsection


