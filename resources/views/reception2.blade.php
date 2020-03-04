@extends('layouts.reception2')

@section('content')
	<div class="row">
	
		<div class="col-md-4" style="background-color:#d1f0f2; border-right: 10px solid white;">
		@php $numberOfVisitors = count($visitors); @endphp
		@if ( $numberOfVisitors > 0)
			<p class="display-2 text-center mt-5">Idag välkomnar vi</p>
			@foreach ($visitors as $visitor)
			<br>
				<div class="row">
					<div class="col-12 h5">
					@if (date('H:i', strtotime($visitor->startTime))<>'00:00') 
					{{date('H:i', strtotime($visitor->startTime)).'. '}}
					@endif
					{{ $visitor->user->name.' '.$visitor->user->surname }} besöks av:</div>
				</div>
				<div class="row">
					<div class="col-12 h1 font-weight-bold">{{ $visitor->company }}</div>
				</div>
				@foreach ($visitor->names as $name)
				
				<div class="row">
					<div class="col-1">&nbsp;</div>
					<div class="col-11 h3">{{ $name->name }}</div>
				</div>
			@endforeach
			@endforeach
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
		<a class="weatherwidget-io" href="https://forecast7.com/sv/59d4013d51/karlstad/" data-label_1="KARLSTAD" data-label_2="VÄDER" data-icons="Climacons Animated" data-days="3" data-theme="pure" >KARLSTAD VÄDER</a>
		<script>
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
		</script>
	</div>
@endsection