@extends('layouts.app')

@section('content')
    <div class='h1'>
        Uppdatera Produkter
    </div>

    <div class="alert alert-info h5">
        <strong>Information</strong>
        <p>
            Produktdatabasen uppdateras genom att importera en excelfil med produktdata.
        </p>
        <ul>
            <li>Filen kan innehålla en eller flera rader. </li>
            <li> Om produktnumret (<code>item</code>) redan finns i databasen kommer alla fält att uppdateras. Finns inte
                produkten kommer den att läggas till.</li>
            <li>Kolumnen <code>item</code> är obligatorisk, övriga fält är valfria.
        </ul>
        <p>
            <a href="{{ route('support.product.template') }}">Ladda ned fil för rätt format</a>
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
