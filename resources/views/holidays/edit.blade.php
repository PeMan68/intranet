@extends('layouts.app')

@section('content')
<div class="card">
	<div class="card-header h3">Ändra ledig dag</div>

	<div class="card-body">
		<form method="POST" action="{{ route('holidays.update', $holiday->id) }}">
			@csrf
			@method('PUT')
			<div class="form-group">
				<label for="date">Datum</label>	
				<b-form-datepicker id="date" name="date" value="{{ $holiday->date }}"></b-form-datepicker>
			</div>
			<div class="form-group">
				<b-form-checkbox
					id="half_day"
					name="half_day"
					value="true"
					checked="{{ $holiday->half_day==1?'true':'false' }}"
					switch>
					Halvdag
				</b-form-checkbox>
			</div>
			
			<div class="form-group">
				<label for="description">Beskrivning (ej obligatoriskt)</label>
				<input id="description" type="text" class="form-control" name="description" value="{{ $holiday->description }}">
			</div>
			<div class="form-group row mb-0">
				<div class="col-md-8 offset-md-4">
					<button type="submit" class="btn btn-primary">Spara</button>
					<button name="delete" value="delete" class="btn btn-danger">Radera</button>

					<a type="button" class="btn btn-secondary" href="{{ route('holidays.index') }}">Avbryt</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
