@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header h3">Lägg in produkt på demolager</div>

	<div class="card-body">
		<form action="/demoproducts" method="post">
            @csrf
            <div class="form-group">
                <label for="product_id">Välj produkt</label>
                <select class="form-control" id="product_id" name="product_id">
                    @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->item }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="place">Plats</label>
                <select class="form-control" name="location_id" id="place">
                    @foreach ($locations as $location)
                    <option value="{{ $location['id'] }}">{{ $location['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status_id" id="status">
                    @foreach ($statuses as $status)
                    <option value="{{ $status->id }}">{{ $status->description }}</option>
                    @endforeach
                </select>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="tested" id="tested" value="1"
                        {{ old('tested') == "1" ? 'checked' : ''}}>
                    <label class="form-check-label" for="tested">Testad, OK</label>
                </div>
            </div>
            <div class="form-group">
                <label for="serial">Serienummer</label>
                <input class="form-control" type="text" name="serial" id="serial" value="{{ old('serial') }}">
                <small class="form-text text-muted">Ange serienumret om det är känt</small>
            </div>
            <div class="form-group">
                <label for="version">Version</label>
                <input class="form-control" 
                    type="text"
                    name="version" 
                    id="version"
                    value="{{ old('version') }}">
                <small class="form-text text-muted">Ange version om det är aktuellt</small>
            </div>
            <div class="form-group">
                <label for="invoice_date">Ungefärlig ålder</label>
                <b-form-radio-group name="invoice_date" id="date" >
                    <b-form-radio value="0">Ny</b-form-radio>
                    <b-form-radio value="1">Max 6 månader</b-form-radio>
                    <b-form-radio value="2">Mer än 6 månader</b-form-radio>
                    <b-form-radio value="3">Mer än 2 år</b-form-radio>
                </b-form-radio-group>
            </div>
            <div class="form-group">
                <label for="invoice_no">Fakturanummer/ordernummer</label>
                    <input class="form-control" 
                    type="text"
                    name="invoice_no"
                    id="invoice_no"
                    value="{{ old('invoice_no') }}">
                <small class="form-text text-muted">Ange fakturanummer eller ordernummer om det är känt</small>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" 
                        type="checkbox"
                        name="original_box" 
                        id="box" 
                        value="1" {{ old('original_box') == "1" ? 'checked' : ''}}>
                        <label class="form-check-label" for="box">Orginal kartong</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" 
                        type="checkbox" 
                        name="original_docs" 
                        id="docs"
                        value="1" {{ old('original_docs') == "1" ? 'checked' : ''}}>
                    <label class="form-check-label" for="docs">Orginal dokumentation</label>
                </div>
            </div>
            <div class="form-group">
                <label for="comment">Kommentar</label>
                <textarea class="form-control" 
                    name="comment" 
                    id="comment" 
                    cols="60" 
                    rows="3">{{ old('comment') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary m-1" name="save">
                Spara
            </button>
        </form>
    </div>
</div>
@endsection