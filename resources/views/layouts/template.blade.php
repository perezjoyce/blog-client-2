<!DOCTYPE html>
<html lang="en">
<html>
<head>
	<title>@yield('title')</title>
	@include('../layouts/header')
</head>
<body>
@include('../layouts/nav')
@yield('admin_body')
@yield('user_body')
@include('../layouts/footer')
</body>
<html>
