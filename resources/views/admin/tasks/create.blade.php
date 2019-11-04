@extends('layouts.app')

@section('content')
	<div class="card">
		<div class="card-header h3">Lägg till Uppgift</div>
		<div class="card-body">
			<form action="{{ url('admin/tasks') }}" method="post">
				@csrf
				<div class="form-group">
				<label for="name" class="font-weight-bold h5">Uppgift</label>
				<input type="text" class="form-control" id="name" name="name">
				</div>
				<div class="form-group">
					<label for="area" class="font-weight-bold h5">Område</label>
					<select class="form-control" id="area" name="area_id">
						@foreach ($areas as $area)
							<option value="{{ $area->id }}" >{{ $area->area }}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="prio" class="font-weight-bold h5">Prioritet</label>
					<select class="form-control" id="prio" name="prio_id">
						@foreach ($priorities as $priority)
							<option value="{{ $priority->id }}"> {{ $priority->description }}</option>
						@endforeach
					</select>
				</div>
				@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				@endif
				<div class="form-group row mb-0">
					<div class="col-md-8 offset-md-4">
						<button type="submit" class="btn btn-primary">
							Spara
						</button>
						<button class="btn btn-secondary" type="submit" name="reset" value="reset">
							Avbryt
						</button>                            
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection