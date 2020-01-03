<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
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
				<div class="col-md-2 bg-dark">
					<nav class="nav flex-column">
						<a class="nav-link" href="{{ url('/issues/create/') }}">Nytt ärende</a>
						<a class="nav-link" href="{{ url('/issues/') }}">Mina ärenden</a>
					</nav>
				</div>
				<div class="col-md-10 p-3">
					@include('partials.alerts')
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
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
