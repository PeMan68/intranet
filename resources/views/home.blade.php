@extends('layouts.app')

@section('content')

<div class="row pb-3">
    <div class="col p-3">
        @include('partials._kalender')
    </div>
    @include('partials._visitors')
</div>

@endsection