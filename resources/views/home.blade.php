@extends('layouts.issues')

@section('nav-left')
	<div class="text-light">CG webb-platser</div>
	<a class="nav-link" href="http://172.16.0.2:10099/INTRANET/SFA/">SFA</a>
	<a class="nav-link" href="http://172.16.0.161">Reserved Area</a>
	<a class="nav-link" href="http://productselection.net">Product Selection</a>
	<a class="nav-link" href="http://gavazzi.se">Nya Gavazzi.se</a>
	<a class="nav-link" href="http://support-carlogavazzi.se">Gamla supportsidan</a>
	<div class="text-light">CG verktyg</div>
	<a class="nav-link" href=" http://172.16.0.184/qweb ">QUARTA</a>
	<a class="nav-link" href="http://194.243.72.228">GESTREQ</a>
	<a class="nav-link" href="http://172.16.0.183/projects/si5/wiki">Dokumentation SIGIP mm</a>
	<a class="nav-link" href="./posten">Posten Adresslappar</a>
	<div class="text-light">Inställningar</div>
	<a class="nav-link" href="{{ route('visitors.index') }}">Hantera Besökare</a>
	@hasrole('superadmin')
		<a class="nav-link" href="{{ url('/admin/tasks/')}}">Hantera ärenden</a>
		<a class="nav-link" href="{{ route('admin.users.index')}}">Hantera användare</a>
		<a class="nav-link" href="{{ route('admin.images.create')}}">Lägg till fil till receptionsskärm</a>
	@endhasrole

@endsection


@section('content')

	<div class="row pb-3">
		<div class="col">
			@include('partials._chart')
		</div>
	</div>
	<div class="row">
		<div class="col pb-3">
			@include('partials._kalender')
		</div>
	</div>
	<div class="row">
		<div class="col pb-3">
			@include('partials._visitors')
		</div>
	</div>

@endsection
