@extends('layouts.app')

@section('content')
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">ID</th>
              <th scope="col">Skapad</th>
              <th scope="col">Kund</th>
              <th scope="col">Namn</th>
              <th scope="col">Beskrivning</th>
            </tr>
          </thead>
          <tbody>
            @foreach($issues as $issue)
            <tr>
              <th scope="row">{{$issue->id}}</th>
              <td><a href="/issues/{{$issue->id}}">{{$issue->timeInit}}</a></td>
              <td>{{$issue->customer}}</td>
              <td>{{$issue->customerName}}</td>
              <td>{{$issue->description}}</td>
              <td>
              <div class="btn-group" role="group" aria-label="Basic example">
                  <a href="{{ URL::to('issues/' . $issue->id . '/edit') }}">
                  	<button type="button" class="btn btn-warning">Edit</button>
                  </a>&nbsp;
                  <form action="{{url('issues', [$issue->id])}}" method="POST">
    					<input type="hidden" name="_method" value="DELETE">
   						<input type="hidden" name="_token" value="{{ csrf_token() }}">
   						<input type="submit" class="btn btn-danger" value="Delete"/>
   				  </form>
              </div>
			</td>
            </tr>
            @endforeach
          </tbody>
        </table>
@endsection