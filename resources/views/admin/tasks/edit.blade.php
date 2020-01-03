@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<div class="card">
				<div class="card-header h3">Ändra Uppgift</div>
				<div class="card-body">
					<form action="{{ route('admin.tasks.update', [$task->id]) }}" method="post">
						@method('PUT')
						@csrf
						<div class="form-group">
							<label for="name" class="font-weight-bold h5">Uppgift beskrivning/namn</label>
							<input type="text" value="{{ $task->name }}" class="form-control" id="name" name="name">
						</div>
						<div class="form-group">
							<label for="area" class="font-weight-bold h5">Område</label>
							<select class="form-control" id="area" name="area_id">
								@foreach ($areas as $area)
									<option value="{{ $area->id }}" @if ($task->area_id==$area->id) selected @endif>{{ $area->area }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label for="prio" class="font-weight-bold h5">Prioritet</label>
							<select class="form-control" id="prio" name="prio_id">
								@foreach ($priorities as $priority)
									<option value="{{ $priority->id }}" @if ($task->prio_id==$priority->id) selected @endif>{{ $priority->description }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group row mb-0">
							<div class="col-md-8 offset-md-4">
								<button type="submit" class="btn btn-primary">
									Spara
								</button>
								<button class="btn btn-secondary" type="submit" name="reset" value="reset">
									Avbryt
								</button>                            
								<button class="btn btn-danger" type="submit" name="delete" value="delete">
									Radera
								</button>                            
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection