@extends('layouts.app')

@section('content')
            <h1>Ärende #{{ $issue->id }}</h1>

    <div class="jumbotron text-center">
        <p>
            <strong>Kund:</strong> {{ $issue->customer }}<br>
            <strong>Beskrivning:</strong> {{ $issue->description }}
        </p>
    </div>
@endsection