@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Hantera tasks</div>

                <div class="card-body">
					<table class="table">
					  <thead>
						<tr>
						  <th scope="col">Namn</th>
						  <th scope="col">Område</th>
						  <th scope="col">Prioritet</th>
						  <th scope="col">Hantera</th>
						  
						</tr>
					  </thead>
					  <tbody>
						@foreach($tasks as $task)
						<tr>
							<td>{{ $task->name}}</td>
							<td>{{ $task->area->area }}</td>
							<td>{{ $task->priority->description }}</td>
							<td>
								<a href="{{ route('admin.tasks.edit', $task->id) }}" class="float-left">
									<button type="button" class="btn btn-sm">Ändra</button>
								</a>
								<form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" class="float-left">
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
