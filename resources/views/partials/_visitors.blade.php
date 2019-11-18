
@if (count($visitors) > 0)
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
					Dagens besök i Karlstad
				</div>
                <div class="card-body">
					<dl class="row">
					@foreach ($visitors as $visitor)
						<dt class="col-sm-4">{{ $visitor->name }}</dt>
						<dd class="col-sm-8">{{ $visitor->company }}</dd>
					@endforeach
					</dl>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
