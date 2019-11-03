@extends('layouts.app')

@section('content')
    <h1>Ändra Uppgift</h1>
    <hr>
     <form action="{{ url('admin/tasks', [$task->id]) }}" method="post">
	 @method('PUT')
     @csrf
      <div class="form-group">
        <label for="name">Uppgift</label>
        <input type="text" value="{{ $task->name }}" class="form-control" id="name" name="name">
      </div>
      <div class="form-group">
        <label for="prio">Prioritet</label>
		<select class="form-control" id="prio" name="prio_id">
			@foreach ($priorities as $priority)
				<option value="{{ $priority->id }}" @if ($task->prio_id==$priority->id) selected @endif>{{ $priority->description }}</option>
			@endforeach
		</select>
      </div>
      <div class="form-group">
        <label for="area">Område</label>
		<select class="form-control" id="area" name="area_id">
			@foreach ($areas as $area)
				<option value="{{ $area->id }}" @if ($task->area_id==$area->id) selected @endif>{{ $area->area }}</option>
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
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection