@extends('layouts.app')

@section('content')
<div class='h1'>
    Lägg till bild till receptionsskärm
</div>

<div class="alert alert-info h5">
    <strong>Information</strong>
    <p>
        Lägg till en bild till bildspelet som visas på receptionsskärm.<br>
    Bilden är den högra delen av skärmen    </p>
<form action="{{ route('admin.images.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    Bild (max 2 MB):
    <br />
    <input type="file" name="image" />
    <br /><br />
    <input type="submit" value=" Save " />
</form>
@endsection
