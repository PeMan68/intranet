<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
</head>
<body>
	<span style='font-size: 0.8em; font-family: Verdana,Arial,sans-serif'>
		<p>
			<a href="{{ url('/issues/'.$issue->id) }}">Öppna ärende</a>
		</p>
		<table>
			<tr>
				<td><b>Typ:</b> </td>
				<td>{{ $issue->task->name }}</td>
			</tr>
			<tr>
				<td><b>Skapat:</b> </td>
				<td>{{ date('Y-m-d H:i', strtotime($issue->created_at)) }}</td>
			</tr>
			<tr>
				<td><b>Skapat av:</b> </td>
				<td>{{ $issue->userCreate->name . ' ' . 
					$issue->userCreate->surname }}</td>
			</tr>
		<table>
		<hr>
		<table>
			<tr>
				<td><b>Kund:</b></td><td>{{ $issue->customer }}</td>
			</tr>
			<tr>
				<td><b>Kundnummer:</b></td><td>{{ $issue->customerNumber }}</td>
			</tr>
			<tr>
				<td><b>Namn:</b></td><td>{{ $issue->customerName }}</td>
			</tr>
			<tr>
				<td><b>Telefon:</b></td><td>{{ $issue->customerTel }}</td>
			</tr>
			<tr>
				<td><b>Mail:</b></td><td>{{ $issue->customerMail }}</td>
			</tr>
		</table>
		<hr>
		<p>
		<b>Ärende:</b><br>
		{{ $issue->description }}
		<br>
		</p>
		<p>
		<b>Intern kommentar:</b><br>
		{{ $issue->descriptionInternal }}
		</p>
		<hr>
		<table>
			<tr>
				<td><b>Kund:</b></td><td>{{ $issue->customer }}</td>
			</tr>
			<tr>
				<td><b>Kundnummer:</b></td><td>{{ $issue->customerNumber }}</td>
			</tr>
			<tr>
				<td><b>Namn:</b></td><td>{{ $issue->customerName }}</td>
			</tr>
			<tr>
				<td><b>Telefon:</b></td><td>{{ $issue->customerTel }}</td>
			</tr>
			<tr>
				<td><b>Mail:</b></td><td>{{ $issue->customerMail }}</td>
			</tr>
		</table>
	@foreach($comments as $comment)
		<tr>
			<td> {{ date('Y-m-d H:i', strtotime($comment->checkin)) }}
			<br>
			{{ $comment->user->name . ' ' . $comment->user->surname }} </td>
			<td> {{ $comment->comment_internal }} </td>
			<td> {{ $comment->comment_external }} </td>
			</form>
		</tr>
	@endforeach
		
    </span>
</body>
</html>