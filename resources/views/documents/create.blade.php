@extends('layouts.app')

@include('menues.documents')

@section('content')
<form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    Kort beskrivning:
    <br />
    <input type="text" name="description" />
    <br /><br />
    Fil:
    <br />
    <input type="file" name="document" />
    <br /><br />
    <input type="submit" value=" Ladda upp " />
</form>
@endsection
