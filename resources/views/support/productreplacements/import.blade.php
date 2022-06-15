@extends('layouts.app')

@section('content')
    <div class='h1'>
        Uppdatera Ersättningsprodukter
    </div>
    <div class="h4">
        Filen ska innehålla kolumn för Produkt, Ersättningsprodukt och Anmärkning.
    </div>
    <p class="h5">
    <ul>
        <li>Både produkt och ersättningsprodukt måste ha exakt artikelnummer och existera i produktdatabasen</li>
        <li>Om både produkt och ersättningsprodukt redan finns uppdateras Anmärkning</li>
    </ul>
    </p>
    <p>
    <div class="alert alert-info h4">
        Ladda ned denna tomma fil för rätt format:
        <a href="{{ asset('files/Ersättningsartiklar.xlsx') }}">Importfil</a>
        </p>
    </div>
    <form action="{{ route('support.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <input id="file" type="file" name="file" class="form-control">
        </div>
        <br>
        <button class="btn btn-success">Importera</button>
    </form>

    @if (session('missingItems'))
        <p>Följande produkter finns inte i Produktdatabasen och raden importerades därför inte.</p>
		@foreach (session('missingItems') as $item)
			Rad: {{ $item['rad'] }}: {{ $item['item']}} <br>
		@endforeach
    @endif
@endsection
