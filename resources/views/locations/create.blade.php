@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<div class="card">
				<div class="card-header h3">Lägg till plats för {{ setting('app_name') }} </div>
				<div class="card-body">
					<form action="{{ route('locations.store') }}" method="post">
						@csrf
						<h4>
						@if ($id == 0)
							Skapa ny huvudplats
						@else
							Ny plats hör till: <span class="font-italic">{{ $parent }}</span>
						@endif
						</h4>
						<input type="hidden" name="parent_id" value="{{$id}}">
						<div class="form-group">
						<label for="name" class="font-weight-bold h5">Beskrivande namn</label>
						<input type="text" class="form-control" id="name" name="name">
						</div>
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
		</div>
	</div>
</div>
@endsection