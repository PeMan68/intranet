@extends('layouts.app')

@section('content')
<div class='h1'>
	Importera fil 'Prislista_sigip.xls'
</div>
	
		<form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="file" name="file" class="form-control">
			<br>
			<button class="btn btn-success">Importera</button>
		</form>
	
@endsection
