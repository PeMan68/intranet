@extends('layouts.issues')

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
<div class="card">
	<div class="card-header">
		<div class="row">
		<div class="col-6">	
		<h3>Mina ärenden</h3>
		</div>
		<div class="col-6">	
				<form class="form-inline float-right" method="POST" action="issues">
					@method('GET')
					@csrf
					<div class="input-group">
						<div class="input-group-prepend">
						<span class="input-group-text"><i class="material-icons">search</i></span>
						</div>		
						<input type=text class="form-control" name="search" placeholder="Sök..." value="{{$filter}}">
					</div>		
				</form>
	</div>
	</div>
	</div>

	<div class="card-body">
		<table class="table table-sm table-hover">
			<thead class="thead-light">
				<tr>
					<th>#</th>
					<th>Skapad</th>
					<th>Område</th>
					<th>Kund</th>
					<th>Namn</th>
					<th>Beskrivning</th>
				</tr>
			</thead>
			<tbody>
			@foreach($issues as $issue)
				<tr class="table-row" data-href="{{ URL::to('issues/' . $issue->id) }}">
					<td>{{$issue->id}}</td>
					<td>{{date('Y-m-d H:i',strtotime($issue->created_at))}}</td>
					<td>{{$issue->task->name ?? '#saknas'}}</td>
					<td>{{$issue->customer}}</td>
					<td>{{$issue->customerName}}</td>
					<td class="d-inline-block text-truncate stretched-link" style="max-width: 300px;" data-toggle="tooltip" title="{{$issue->description }}">{{$issue->description}}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
		{{ $issues->links() }}
	</div>
</div>
@endsection