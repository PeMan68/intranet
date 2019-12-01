@extends('layouts.issues')

@section('content')
<div class="card">
	<div class="card-header h3">Ärende #{{ $issue->id }}
		<a href="#" class="btn btn-outline-secondary">Uppdatera ärendeinfo</a>
		<a href="#" class="btn btn-outline-secondary">Checka ut</a>
	</div>

	<div class="card-body">
		<table>
            <tr><td><strong>Ärende skapat:</strong></td><td> {{ date('Y-m-d H:i', strtotime($issue->created_at)) }}</td></tr>
            <tr><td><strong>Kundnr:</strong></td><td> {{ $issue->customerNumber }}</td></tr>
            <tr><td><strong>Kund:</strong></td><td> {{ $issue->customer }}</td></tr>
            <tr><td><strong>Kontakt:</strong></td><td> {{ $issue->customerName }}
            <tr><td><strong>Telefon:</strong></td><td> {{ $issue->customerTel }}
            <tr><td><strong>E-mail:</strong></td><td> {{ $issue->customerMail }}
            <tr><td><strong>Ärendebeskrivning:</strong></td><td> {{ $issue->description }}
            <tr><td><strong>Intern kommentar:</strong></td><td> {{ $issue->descriptionInternal }}
		</table>
		@if($comments->count())
		<table class="table table-sm mt-4">
			<thead>
				<th>Händelselogg</th>
				<th>Kommentar skickad till kund</th>
			</thead>
		@foreach($comments as $comment)
			<tr>
				<td> {{$comment->comment_internal}} </td>
				<td> {{$comment->comment_external}} </td>
			</tr>
		@endforeach
		</table>
		@endif
				
	</div>
</div>
@endsection