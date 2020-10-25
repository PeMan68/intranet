@extends('layouts.app')


@section('content')
<div class="card">
	<div class="card-header h3">Lägg in produkt på demolager</div>

	<div class="card-body">
		<form action="/demoproducts" method="post">
            @csrf
            <select class="form-control" id="product_id" name="product">
                @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->item }}</option>
                @endforeach
            </select>
            <input class="form-control" type="number" id="number" name="number">
            <select class="form-control" name="place" id="place">
                @foreach ($locations as $location)
                <option value="{{ $location['id'] }}">{{ $location['name'] }}</option>                 
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary m-1" name="save">
                Spara
            </button>
        </form>
    </div>
</div>
@endsection