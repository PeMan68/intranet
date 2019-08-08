@extends('layouts.basic')

@section('title','Home')

@section('header','Tasks i databasen')

@section('content')
	@php
	use App\Helpers\Helper;
	echo '<h2>Lägg till tasks</h2><br>';
	add_responsibilites();
	echo '<h2>Ta bort tasks</h2><br>';
	delete_responsibilites();
	
	@endphp
@endsection
