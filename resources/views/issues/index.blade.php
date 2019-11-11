@extends('layouts.app')

@section('scriptsBody')
<script>
$(document).ready(function($) {
    $(".table-row").click(function() {
        window.document.location = $(this).data("href");
    });
});
</script>
@endsection

@section('content')
        @if (Session::has('message'))
            <div class="alert alert-info">{{ Session::get('message') }}</div>
        @endif
        <table class="table table-hover">
          <thead class="thead-dark">
            <tr>
              <th>#</th>
              <th>Skapad</th>
              <th>Kund</th>
              <th>Namn</th>
              <th>Beskrivning</th>
            </tr>
          </thead>
          <tbody>
            @foreach($issues as $issue)
            <tr class="table-row" data-href="{{ URL::to('issues/' . $issue->id . '/edit') }}">
              <td>{{$issue->id}}</th>
              <td>{{$issue->timeInit}}</td>
              <td>{{$issue->customer}}</td>
              <td>{{$issue->customerName}}</td>
              <td class="d-inline-block text-truncate stretched-link" style="max-width: 200px;">{{$issue->description}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
@endsection