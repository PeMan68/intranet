<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <div>
		<div>
			Nytt ärende
		</div>
		<table>
			<tr>
				<td>Typ: </td>
				<td>{{ $issue->task->name }}</td>
			</tr>
			<tr>
				<td>Skapat: </td>
				<td>{{ date('Y-m-d H:i', strtotime($issue->created_at)) }}</td>
			</tr>
			<tr>
				<td>Skapat av: </td>
				<td>{{ $issue->userCreate->name . ' ' . 
					$issue->userCreate->surname }}</td>
			</tr>
		<table>
		<hr>
		<table>
			<tr>
				<td>Kund:</td><td>{{ $issue->customer }}</td>
			</tr>
			<tr>
				<td>Kundnummer:</td><td>{{ $issue->customerNumber }}</td>
			</tr>
			<tr>
				<td>Namn:</td><td>{{ $issue->customerName }}</td>
			</tr>
			<tr>
				<td>Telefon:</td><td>{{ $issue->customerTel }}</td>
			</tr>
			<tr>
				<td>Mail:</td><td>{{ $issue->customerMail }}</td>
			</tr>
		</table>
		<hr>
		<div>
		Ärende:<br>
		{{ $issue->description }}
		<br>
		</div>
		<div>
		Intern kommentar:<br>
		{{ $issue->descriptionInternal }}
		</div>
		<div>
			Öppna <a href="{{ url('/issues/'.$issue->id) }}">ärende</a>
		</div>
		
    </div>
</body>
</html>