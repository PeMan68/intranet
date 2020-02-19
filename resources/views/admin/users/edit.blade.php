@extends('layouts.issues')

@section('content')
            <div class="card">
                <div class="card-header h3">Hantera &quot;{{ $user->name }} {{ $user->surname }}&quot;</div>
					<div class="card-body">
						<form action="{{ route('admin.users.update', ['user' => $user->id]) }}" method="POST">
							@csrf
							@method('PUT')
							<p class="font-weight-bold h5">Ange avdelning för användaren</p>
							<div class="form-group row">
								@foreach($departments as $department)
									<div class="form-check">
										<input id="departments" type="checkbox" name="departments[]" value="{{ $department->id }}"
											{{ $user->hasAnyDepartment($department->name)?'checked':'' }}>
										<label>{{ $department->name }}</label>
									</div>
								@endforeach
							</div>
							<hr>
							<p class="font-weight-bold h5">Ange roll för användaren</p>
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
							<p class="font-weight-bold h5">Ange ansvarsområden för användaren</p>
							<p class="text">
							0=Inget |
							1=Sista hand |
							2=Andra hand |
							3=Första hand
							</p>
								@foreach($tasks as $task)
							<fieldset class="form-group">
							<div class="row">
								<legend class="col-form-label col-sm-2 pt-0">{{ $task->area->area}}</legend>
								<legend class="col-form-label col-sm-2 pt-0">{{ '- ' . $task->name }}</legend>
								<input type="hidden" name="tasks[]" value="{{ $task->id }}">
								<div class="col-sm-8">
									
										@for ($i = 0; $i < 4; $i++)
									<div class="form-check form-check-inline position-static">
										<input id="tasks" type="radio" name="levels[{{ $task->id }}]" value="{{ $i }}"
											{{ $x = $user->tasks()->find($task->id)->pivot->level ?? '0' }}
											{{	$x == $i ? 'checked' : '' }}>
									<label class="form-check-label">{{ $i }}</label>
									</div>
										@endfor
								</div>
							</div>
							</fieldset>
								@endforeach
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
