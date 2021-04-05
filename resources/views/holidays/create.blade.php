@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header h3">Lägg till ledig dag</div>

	<div class="card-body">
		<form method="POST" action="{{ route('holidays.store') }}">
			@csrf
			
			<div class="form-group">
				<label for="date">Datum</label>	
				<b-form-datepicker id="date" name="date" value="{{ now() }}"></b-form-datepicker>
			</div>
			<div class="form-group">
				<b-form-checkbox
					id="half_day"
					name="half_day"
					value="true"
					switch>
					Halvdag
				</b-form-checkbox>
			</div>
			
			<div class="form-group">
				<label for="description">Beskrivning (ej obligatoriskt)</label>
				<input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}">
			</div>
			<div class="form-group row mb-0">
				<div class="col-md-8 offset-md-4">
					<button type="submit" class="btn btn-primary">Spara</button>
					<a type="button" class="btn btn-secondary" href="{{ route('holidays.index') }}">Avbryt</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
