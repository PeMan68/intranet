@extends('layouts.app')

@section('content')
    <div class='h1'>
        Uppdatera Ersättningsprodukter
    </div>

    <div class="alert alert-info h5">
        <p>
            Importera excelfil med kolumnerna <code>Item</code>, <code>Replacement</code> och <code>Remark</code>
        </p>
            <strong>Regler</strong>
        <ul>
            <li>Både <code>Item</code> och <code>Replacement</code> måste ha exakt artikelnummer och existera i
                produktdatabasen</li>
            <li>Om både <code>Item</code> och <code>Replacement</code> redan finns uppdateras <code>Remark</code></li>
        </ul>
    </div>
    <p>
        Ladda ned denna tomma fil för rätt format:
        <a href="{{ asset('files/Ersättningsartiklar.xlsx') }}">Ersättningsartiklar.xlsx</a>
    </p>
    <form action="{{ route('support.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <input id="file" type="file" name="file" class="form-control">
        </div>
        <br>
        <button class="btn btn-success">Importera</button>
    </form>
@endsection
