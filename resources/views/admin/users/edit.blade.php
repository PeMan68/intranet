@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Hantera {{ $user->name }} {{ $user->surname }}</div>
					<div class="card-body">
						<form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="POST">
							@csrf
							{{ method_field('PUT') }}
							<p>Roller</p>
							<div class="form-group row">
								@foreach($roles as $role)
									<div class="form-check">
										<input id="roles" type="checkbox" name="roles[]" value="{{ $role->id }}"
											{{ $user->hasAnyRole($role->name)?'checked':'' }}>
										<label>{{ $role->name }}</label>
									</div>
								@endforeach
							</div>
							<div class="form-group row">
									<div class="form-check">
										<input id="active" type="checkbox" name="active" value="1"
											{{ $user->active?'checked':'' }}>
										<label>Användare aktiv</label>
									</div>
							</div>
							<div class="form-group row">

									<div class="form-check">
										<input id="calendar" type="checkbox" name="calendar" value="1"
											{{ $user->calendar?'checked':'' }}>
										<label>Användare visas i kalender</label>
									</div>
							</div>	
							<button type="submit" class="btn btn-primary">
							Uppdatera
							</button>
						</form>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
