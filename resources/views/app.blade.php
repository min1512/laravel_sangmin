<!doctype html>
<html>
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8" />
    <title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href='/css/test.css'>
	<script type="text/javascript" src="/script/test.js" charset="utf-8"></script>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    @yield('scripts')
    @yield('styles')
</head>
<body>
    @include('headers.nav')

    @yield('content')

	@include('footers.nav')
</body>
</html>
