@extends('layouts.reception2')

@section('content')
	<div class="row">
	
		<div class="col-md-4" style="background-color:#d1f0f2;">
		@if (count($visitors) > 0)
		<p class="h1 text-center mt-5">Idag gästas vi av</p>
				<dl class="row h3" style="color:#000000;">
				@foreach ($visitors as $visitor)
					<dt class="col-sm-2"></dt>
					<dt class="col-sm-4">{{ $visitor->name }}</dt>
					<dd class="col-sm-6">{{ $visitor->company }}</dd>
				@endforeach
			</dl>
		@endif
		</div>
		<div class="col-md-8 p-0">
			<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel" data-interval="10000">
			  <div class="carousel-inner">
				@foreach ($files as $image)
				@if ($loop->first)
					
				<div class="carousel-item active">
					<img src="{{ asset('storage') . '/' . $image }}" class="d-block w-100" alt="...">
				</div>
				@else
				<div class="carousel-item">
					<img src="{{ asset('storage') . '/' . $image }}" class="d-block w-100" alt="...">
				</div>
					
				@endif
				
				@endforeach
			  </div>
			</div>		
		
		</div>
	</div>
	<div class="fixed-bottom">
		<table>
		<tr><td>
</td><td>		<a class="weatherwidget-io" href="https://forecast7.com/sv/59d4013d51/karlstad/" 
			data-label_1="KARLSTAD" 
			data-label_2="Väder" 
			data-theme="original" 
			data-forecast=3>
			KARLSTAD Väder
		</a>
</td></tr>
</table>
		<script>
			!function(d,s,id){
				var js,fjs=d.getElementsByTagName(s)[0];
				if(!d.getElementById(id)){
					js=d.createElement(s);
					js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';
					fjs.parentNode.insertBefore(js,fjs);
				}
			}
			(document,'script','weatherwidget-io-js');
		</script>
	</div>
@endsection