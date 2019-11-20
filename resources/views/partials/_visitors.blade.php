
@if (count($visitors) > 0)
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">
					Veckans besök i Karlstad
				</div>
                <div class="card-body">
					<table class="table table-borderless">
					@foreach ($visitors as $visitor)
						<tr>
							<td>{{ $visitor->start }} {{ ($visitor->start <> $visitor->stop) ? ' - ' . $visitor->stop :''}}</td>
							<td>{{ $visitor->name }}</td>
							<td>{{ $visitor->company }}</td>
						<tr>
					@endforeach
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
