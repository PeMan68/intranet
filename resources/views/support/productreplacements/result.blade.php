@extends('layouts.app')

@section('content')
    <div class='h1'>
        Resultat
    </div>
    <div class="alert alert-success h5">
        {{ session('numberOfImportedItems') }} rader importade!
    </div>
    @if (session('missingItems'))
        <div class="alert alert-danger h5">
            <p>Följande produkter finns inte i Produktdatabasen och raden importerades därför inte.</p>
            <p><a href="{{ route('support.replacement.create') }}">Ladda ned produktfil med saknade produkter</a> Formaterad för <a href="{{ route('support.product.importform') }}">import av nya produkter</a></p>
            <p><a href="{{ route('support.replacement.missing') }}">Ladda ned excelfil med ej importerade rader</a></p>
            @foreach (session('missingItems') as $item)
                Rad {{ $item['rad'] }}: {{ $item['item'] }} <br>
            @endforeach
        </div>
    @endif
@endsection
