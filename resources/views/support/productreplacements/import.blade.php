@extends('layouts.app')

@section('content')
    <div class='h1'>
        Uppdatera Ersättningsprodukter
    </div>

    <div class="alert alert-info h5">
        <strong>Information</strong>
        <p>
            Produktdatabasen uppdateras genom att importera en excelfil med produktdata.
        </p>
        <ul>
            <li>Filen kan innehålla en eller flera rader. </li>
            <li>Kolumnerna <code>item</code> och <code>replacement</code> är obligatoriska, övriga fält är valfria.
            <li>Om både <code>item</code> och <code>replacement</code> redan finns uppdateras <code>Remark</code></li>
            <li>Både <code>item</code> och <code>replacement</code> måste ha exakt artikelnummer och existera i
                produktdatabasen</li>
            <li> Produkter som inte matchas mot produktdatabasen sparas i en fil som kan hämtas och redigeras efter importen
            </li>
        </ul>
        <p>
            <a href="{{ route('support.replacement.template') }}">Ladda ned fil för rätt format</a>
        </p>
    </div>
    <form action="{{ route('support.replacement.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <input id="file" type="file" name="file" class="form-control">
        </div>
        <br>
        <button class="btn btn-success">Importera</button>
    </form>
@endsection
