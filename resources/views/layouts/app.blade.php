<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
	@yield('scriptsHead')
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/extras.css') }}" rel="stylesheet">
	@yield('stylesheets')
</head>
<body>
    <div id="app">
	@include('partials._navbar')


        <main class="container-fluid">
			<div class="row">
				<div class="d-none d-sm-block col-md-3 col-sm-4 bg-dark">
					<nav class="nav flex-column" style="height:100vh; margin-top:-55px; padding-top:55px;">
						@yield('nav-left')
						@include('menues.main')
						<div class="fixed-bottom text-light font-weight-lighter">
							@include('version')
						</div>
					</nav>
				</div>
				<div class="col-md-9 col-sm-8 p-3">
					@include('partials.alerts')
					@if (Session::has('message'))
					<app-message>{{ Session::get('message') }}</app-message>
					@endif
					@yield('content')
				</div>
			</div>        
		</main>
	</div>
	@include('partials._scripts')
	@yield('scriptsBody')
</body>
</html>
