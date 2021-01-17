<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
</head>
<body>
	<span style='font-size: 1em; font-family: Verdana,Arial,sans-serif'>
		<p>
			@yield('header')
		</p>
	</span>

	<span style='font-size: 0.8em; font-family: Verdana,Arial,sans-serif'>
		<p>
			@yield('message')
		</p>
		<hr>
		<table>
			<tr>
				<td><b>Skapat:</b> </td>
				<td>{{ date('Y-m-d H:i', strtotime($issue->created_at)) }}</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
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
		<p>
		<b>Rubrik:</b><br>
		{!! nl2br(e($issue->header)) !!}
		<br>
		</p>
		<p>
		<b>Ärendebeskrivning:</b><br>
		{!! nl2br(e($issue->description)) !!}
		<br>
		</p>
		<hr>
		 {{--// ! Gör om innehållet i mailet. comment_external är raderad från DB!  --}}
		{{-- @if (!empty($issue->issueComments->comment_external))
		<b>Händelselogg</b>
		@foreach($issue->issueComments as $comment)

			@if (isset($comment->comment_external))
			<hr>
				{{ date('Y-m-d H:i', strtotime($comment->checkin))  }}
				{!! nl2br(e($comment->comment_external)) !!} 
			@endif
		@endforeach
		<p>&nbsp;</p>
		@endif --}}

    </span>
</body>
</html>