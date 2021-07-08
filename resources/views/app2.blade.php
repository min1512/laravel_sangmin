<!doctype html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>

{{--    @include('headers.nav')--}}

    @yield('content')

	@include('footers.nav')
</body>
</html>
