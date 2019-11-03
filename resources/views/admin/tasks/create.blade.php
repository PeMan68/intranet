@extends('layouts.app')

@section('content')
    <h1>Lägg till Uppgift</h1>
    <hr>
     <form action="/tasks" method="post">
     @csrf
      <div class="form-group">
        <label for="name">Uppgift</label>
        <input type="text" class="form-control" id="name" name="name">
      </div>
      <div class="form-group">
        <label for="prio">Prioritet</label>
        <input type="text" class="form-control" id="prio" name="prio_id">
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