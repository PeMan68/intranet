@extends('layouts.reception')

@section('content')
	<img src="images/CG-RedBlack.png" class="img-fluid float-right m-2" style="width:15%; height:auto;">
	<iframe scrolling="no" frameborder="no" clocktype="html5" class="float-left m-2" style="overflow:hidden;border:0;margin:0;padding:0;width:200px;height:200px;"src="https://www.clocklink.com/html5embed.php?clock=005&timezone=CET&color=red&size=200&Title=&Message=&Target=&From=2019,1,1,0,0,0&Color=red"></iframe>	<p class="display-1 text-center" style="color:rgb(120, 120, 120);">Välkommen till Carlo Gavazzi</p>
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