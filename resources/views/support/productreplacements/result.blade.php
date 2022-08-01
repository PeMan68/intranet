@extends('layouts.app')

@section('content')
    <div class='h1'>
        Resultat
    </div>
    <div class="alert alert-info h5">
        {{ !is_null(session('missingItems')) ? !is_null(session('numberOfImportedItems')) ? session('numberOfImportedItems') : 0 : 'Alla'}} rader importade!
    </div>
    @if (session('missingItems'))
        <div class="alert alert-info h5">
            <p>Följande produkter finns inte i Produktdatabasen och raden importerades därför inte.</p>
            <p>Gör följande steg för att rätta problemet:</p>
            <ol>
                <li>Ladda ned fil innehållande ej importerade rader<a href="{{ route('support.replacement.missing') }}"><i
                            class="material-icons">download</i></a>
                </li>
                <li>Kontrollera att alla artikelnummer är korrekta nedan eller i filen. Är de korrekta, gå till nästa steg (3). I annat fall, korrigera artikelnummer i filen och importera från början igen</li>
                <li>Ladda ned produktfil med saknade produkter: <a href="{{ route('support.replacement.create') }}"><i
                            class="material-icons">download</i></a></li>
                <li>Importera produkterna i filen till Produktdatabasen.
                    <strong>OBS! Kontrollera alla artikelnummer i filen först!</strong>
                    (<a href="{{ route('support.product.importform') }}">Uppdatera produkter</a>)
                </li>
                <li>Importera därefter de saknade ersättningsartiklarna igen.
                    <strong>OBS! Kontrollera alla artikelnummer i filen först!</strong>
                </li>
            </ol>
        </div>
        <div class="alert alert-danger h5">
            @foreach (session('missingItems') as $item)
                Rad {{ $item['rad'] }}: {{ $item['item'] }} <br>
            @endforeach
        </div>
    @endif
@endsection
