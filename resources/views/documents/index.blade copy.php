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
		<table class="table table-sm">
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
					<td class="d-lg-table-cell">
					<a href="{{ URL::to('documents/download/' . $file->id) }}">
					{{ $file->filename }}</a></td>
					<td class="d-none d-lg-table-cell text-right">
					{{ readableBytes($file->size) }}</td>
					<td class="d-none d-lg-table-cell text-center">
					{{ $file->version }}</td>
					<td class="d-none d-lg-table-cell">
					{{ $file->created_at }}</td>
					<td class="d-none d-lg-table-cell">
					{{ $file->user->name . ' ' . $file->user->surname }}</td>
					<td class="d-lg-table-cell">
					<div class="d-inline-block text-truncate stretched-link" style="max-width: 300px;" data-toggle="tooltip" title="{{ $file->description }}">{{ $file->description }}
					</div>
					</td>
					<td>
						<form method="POST" action="/documents/{{ $file->id }}">
						@method('DELETE')
						@csrf
						<button type="submit" class="btn btn-danger btn-sm show_confirm" name="delete">
						<i class="material-icons white md-18"
						style="vertical-align: middle;">delete</i>
						</button>
						</form>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
	
@endsection
