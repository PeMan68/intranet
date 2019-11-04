@extends('layouts.app')

@section('content')
            <div class="card">
                <div class="card-header h3">Hantera ärendekategorier <a class="btn btn-outline-primary float-right" href="{{ route('admin.tasks.create') }}">Skapa ny</a></div>
                <div class="card-body">
					
					<table class="table">
					  <thead>
						<tr>
						  <th scope="col">Beskrivning</th>
						  <th scope="col">Område</th>
						  <th scope="col">Prioritet</th>  
						</tr>
					  </thead>
					  <tbody>
						@foreach($tasks as $task)
						<tr>
							<td>
							<a href="{{ route('admin.tasks.edit', $task->id) }}">{{ $task->name}}</a>
							</td>
							<td>{{ $task->area->area }}</td>
							<td>{{ $task->priority->description }}</td>
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
