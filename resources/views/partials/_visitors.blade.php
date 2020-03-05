
            <div class="card">
                <div class="card-header">
					Veckans besök i Karlstad
				</div>
                <div class="card-body">
@if (count($visitors) > 0)
					<table class="table table-borderless">
					@foreach ($visitors as $visitor)
						<tr>
							<td>{{ $visitor->user->name }} {{ $visitor->user->surname }}: </td>
							<td>{{ $visitor->company }}</td>
						<tr>
					@endforeach
					</table>
@endif
				</div>
			</div>
