<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
    <div>
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
    </div>
</body>
</html>