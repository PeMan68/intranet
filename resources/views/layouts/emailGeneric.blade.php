<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
</head>
<body>
	<span style='font-size: 1em; font-family: Verdana,Arial,sans-serif'>
		<p>
			@yield('header')
		</p>
	</span>

	<span style='font-size: 0.8em; font-family: Verdana,Arial,sans-serif'>
		<p>
			@yield('message')
		</p>
    </span>
</body>
</html>