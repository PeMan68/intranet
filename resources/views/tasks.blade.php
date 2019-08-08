@extends('layouts.basic')

@section('title','Home')

@section('header','Tasks i databasen')

@section('content')
	<?php
	use App\Helpers\Helper;
	update_responsibilites();?>
@endsection
