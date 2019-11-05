@extends('layouts.app')

@section('content')
            <div class="card">
                <div class="card-header h3">Hantera &quot;{{ $user->name }} {{ $user->surname }}&quot;</div>
					<div class="card-body">
						<form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="POST">
							@csrf
							@method('PUT')
							<p class="font-weight-bold h5">Ange roller för användaren</p>
							<div class="form-group row">
								@foreach($roles as $role)
									<div class="form-check">
										<input id="roles" type="checkbox" name="roles[]" value="{{ $role->id }}"
											{{ $user->hasAnyRole($role->name)?'checked':'' }}>
										<label>{{ $role->name }}</label>
									</div>
								@endforeach
							</div>
							<hr>
							<div class="form-group row">
									<div class="form-check">
										<input id="active" type="checkbox" name="active" value="1"
											{{ $user->active?'checked':'' }}>
										<label>Användare aktiv</label>
									</div>
							</div>
							<hr>
							<div class="form-group row">

									<div class="form-check">
										<input id="calendar" type="checkbox" name="calendar" value="1"
											{{ $user->calendar?'checked':'' }}>
										<label>Användare visas i kalender</label>
									</div>
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
</div>
@endsection
