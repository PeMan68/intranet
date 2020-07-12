@extends('layouts.app')

@include('menues.documents')

@section('scriptsBody')
<script>
$(document).ready(function($) {
    $(".link-cell").click(function() {
        window.document.location = $(this).data("href");
    });
});
</script>
<script>
    $('.show_confirm').click(function(e) {
        if(!confirm('Är du säker på att du vill radera filen?')) {
            e.preventDefault();
			window.location.replace('/documents');
        }
    });

</script>
@endsection

@section('content')
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-6">
				<h3>Dokumenthantering</h3>
			</div>
		</div>
	</div>
	<div class="card-body">
		<table class="table table-sm table-hover">
			<thead class="thead-light">
				<tr>
					<th class="d-none d-lg-table-cell">fil</th>
					<th class="d-none d-lg-table-cell text-right">storlek</th>
					<th class="d-none d-lg-table-cell text-center">version</th>
					<th class="d-none d-lg-table-cell">uppladdad</th>
					<th class="d-none d-lg-table-cell">av</th>
					<th class="d-none d-lg-table-cell">beskrivning</th>
					<th class="d-none d-lg-table-cell"></th>
				</tr>
			</thead>
			<tbody>
			@foreach ($files as $file)
				<tr class="table-row">
					<td class="d-none d-lg-table-cell link-cell" data-href="{{ URL::to('documents/download/' . $file->id) }}">
					{{ $file->filename }}</a></td>
					<td class="d-none d-lg-table-cell text-right link-cell" data-href="{{ URL::to('documents/download/' . $file->id) }}">
					{{ readableBytes($file->size) }}</a></td>
					<td class="d-none d-lg-table-cell text-center link-cell" data-href="{{ URL::to('documents/download/' . $file->id) }}">
					{{ $file->version }}</a></td>
					<td class="d-none d-lg-table-cell link-cell" data-href="{{ URL::to('documents/download/' . $file->id) }}">
					{{ $file->created_at }}</a></td>
					<td class="d-none d-lg-table-cell link-cell" data-href="{{ URL::to('documents/download/' . $file->id) }}">
					{{ $file->user->name . ' ' . $file->user->surname }}</a></td>
					<td class="d-none d-lg-table-cell link-cell" data-href="{{ URL::to('documents/download/' . $file->id) }}">
					{{ $file->description }}</a></td>
					<td>
						<form method="POST" action="{{ url('documents', [$file]) }}">
						@method('DELETE')
						@csrf
						<button type="submit" class="btn btn-danger btn-sm show_confirm" name="delete">
						<i class="material-icons white md-18"
						style="vertical-align: middle;">delete</i>
						</button>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
	
@endsection
