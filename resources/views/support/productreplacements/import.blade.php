@extends('layouts.app')

@section('content')
<div class='h1'>
	Importera fil 'Ersättningsprodukter.xlsx'
</div>
	
		<form action="{{ route('support.import') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="file" name="file" class="form-control">
			<br>
			<button class="btn btn-success">Importera</button>
		</form>
	
		<a href="{{asset('files/Ersättningsartiklar.xlsx')}}">Mall</a>
@endsection
