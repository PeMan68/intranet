@extends('layouts.app')

@section('content')
<div class="card">
<div class="card-header">
	<h3>Importera fil med produktdata</h3>
</div>
<div class="card-body">
		<form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<input type="file" name="file" class="form-control">
			<br>
			<button class="btn btn-success">Importera</button>
		</form>
</div>
</div>
<div class="card mt-3">
	<div class="card-header">
<h3>	Importera fil med ersättningprodukter</h3>
</div>
<div class="card-body">
	<form action="{{ route('support.import') }}" method="POST" enctype="multipart/form-data">
		@csrf
		<input type="file" name="file" class="form-control">
		<br>
		<button class="btn btn-success">Importera</button>
	</form>
</div>
</div>
@endsection
