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
			@yield('content')
		@include('partials._scripts')
		@yield('scripts')
  </body>
</html>