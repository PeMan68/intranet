@extends('layouts.app')

@section('content')
    <h1>Ändra ärende #{{$issue->id}}</h1>
    <hr>
     <form action="{{ url('issues', [$issue->id]) }}" method="post">
	 @method('PUT')
     @csrf
      <div class="form-group">
        <label for="customer">Kund</label>
        <input type="text" value="{{ $issue->customer }}" class="form-control" id="issueCustomer"  name="customer">
      </div>
      <div class="form-group">
        <label for="description">Beskrivning</label>
        <input type="text" value="{{ $issue->description }}" class="form-control" id="issueDescription" name="description">
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
      <button type="submit" class="btn btn-primary">Spara</button>
    </form>
@endsection