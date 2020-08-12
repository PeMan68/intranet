@extends('layouts.app')

@include('menues.documents')

@section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3>Dokumenthantering - Ladda upp dokument</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="form-group">
				<label for="description" class="font-weight-bold">Kort beskrivning</label>
				<input type="text" class="form-control form-control-sm" id="description"  name="description" value="{{ old('description') }}">
			</div>
			<div class="form-group">
				<label for="document" class="font-weight-bold">Fil (Max 2MB)</label>
				<input type="file" class="form-control form-control-sm" id="document"  name="document" value="{{ old('document') }}" style="height: calc(1.68125rem + 8px);">
			</div>
			<div class="form-group">
				<input type="submit" value=" Ladda upp " />
			</div>
		</form>
	</div>
@endsection
