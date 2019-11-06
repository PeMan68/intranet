@extends('layouts.reception')

@section('content')
	<img src="images/CG-RedBlack.png" class="img-fluid float-right m-2" style="width:15%; height:auto;">
	<p class="display-1 text-center" style="color:rgb(120, 120, 120);">Välkommen till Carlo Gavazzi</p>
	<hr class="my-4">
	@if (count($visitors) > 0)
	<p class="display-4 text-center" style="color:#FFFFFF;">Idag gästas vi av</p>
			<dl class="row display-3" style="color:#FFFFFF;">
			@foreach ($visitors as $visitor)
				<dt class="col-sm-2"></dt>
				<dt class="col-sm-4">{{ $visitor->name }}</dt>
				<dd class="col-sm-6">{{ $visitor->company }}</dd>
			@endforeach
		</dl>
	@endif
@endsection