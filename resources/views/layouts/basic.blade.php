<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>
	@include('partials._stylesheets')
	@yield('stylesheets')
  </head>
  <body>
	@include('partials._navbar')
	<div class="container">
		<div class="row">
			<h1>@yield('header')</h1>
		</div>
		<div class="row">
			@yield('content')
		</div>
		@include('partials._scripts')
		@yield('scripts')
  </body>
</html>