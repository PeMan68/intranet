@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Hantera användare</div>

                <div class="card-body">
					<table class="table">
					  <thead>
						<tr>
						  <th scope="col">Förnamn</th>
						  <th scope="col">Efternamn</th>
						  <th scope="col">Email</th>
						  <th scope="col">Aktiv</th>
						  <th scope="col">Visa i kalender</th>
						  <th scope="col">Roll</th>
						  <th scope="col">Hantera</th>
						  
						</tr>
					  </thead>
					  <tbody>
						@foreach($users as $user)
						<tr>
							<td>{{ $user->name}}</td>
							<td>{{ $user->surname}}</td>
							<td>{{ $user->email}}</td>
							<td>{{ $user->active}}</td>
							<td>{{ $user->calendar}}</td>
							<td>{{ implode(', ', $user->roles()->get()->pluck('name')->toArray()) }}</td>
							<td>
								<a href="{{ route('admin.users.edit', $user->id) }}" class="float-left">
									<button type="button" class="btn btn-sm">Ändra</button>
								</a>
								<a href="{{ route('admin.impersonate', $user->id) }}" class="float-left">
									<button type="button" class="btn btn-sm">Agera som</button>
								</a>
								<form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="float-left">
									@csrf
									{{ method_field('DELETE') }}
									<button type="submit" class="btn btn-danger btn-sm">Radera</button>
								</form>
							</td>
						</tr>
						@endforeach
					  </tbody>
					</table>
				</div>
            </div>
        </div>
    </div>
</div>
@endsection
