@if (count($visitors) > 0)
<div class="col-xl-3 p-3">
	<div class="card">
		<div class="card-header">
			Veckans besök i Karlstad
		</div>
		<div class="card-body">
			<table class="table table-borderless">
				@foreach ($visitors as $visitor)
				<tr>
					<td>{{ $visitor->user->name }} {{ $visitor->user->surname }}: </td>
					<td>{{ $visitor->company }}</td>
				<tr>
					@endforeach
			</table>
		</div>
	</div>
</div>
@endif