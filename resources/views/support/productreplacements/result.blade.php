@extends('layouts.app')

@section('content')
    <div class='h1'>
        Resultat
    </div>
    <div class="alert alert-success h5">
        {{ session('importedItems') }} rader importade!
    </div>
    @if (session('missingItems'))
        <div class="alert alert-danger h5">
            <p>Följande produkter finns inte i Produktdatabasen och raden importerades därför inte.</p>
            <a href="export">Ladda ned excelfil</a>
            @foreach (session('missingItems') as $item)
                Rad {{ $item['rad'] }}: {{ $item['item'] }} <br>
            @endforeach
        </div>
    @endif
@endsection
