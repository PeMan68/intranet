@extends('layouts.app')

@section('content')
<form action="{{ route('admin.images.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    Book title:
    <br />
    <input type="text" name="title" />
    <br /><br />
    Logo:
    <br />
    <input type="file" name="image" />
    <br /><br />
    <input type="submit" value=" Save " />
</form>
@endsection
