<!DOCTYPE html>
<html lang="en">
<html>
	<head>
		<title>@yield('title')</title>
		@include('../layouts/header')
	</head>
	<body>
	@include('../layouts/nav')
		<main class="main-content">
			<!-- NOTIFICATIONS -->
  			
						@if($errors->any())
							<div class="rounded-0">
								<ul class='list-unstyled'>
									@foreach ($errors->all() as $error)
										<script>
											var toastHTML = '<span>{{ $error }}</span>';
											M.toast({html: toastHTML, classes: 'rounded'});
										</script>
									@endforeach
								</ul>
							</div>
						@elseif(Session::has("successMessage"))
							<div class="rounded-0">
								<ul class='list-unstyled'>
									<script>
										var toastHTML = '<span>{{ Session::get('successMessage') }}</span>';
										M.toast({html: toastHTML, classes: 'rounded'});
									</script>
								</ul>
							</div>
						@elseif(Session::has("deleteMessage"))
							<div class="rounded-0">
								<ul class='list-unstyled'>
									<script>
										var toastHTML = '<span>{{ Session::get('deleteMessage') }}</span>';
										M.toast({html: toastHTML, classes: 'rounded'});
									</script>
								</ul>
							</div>
						@elseif(Session::has("errorMessage"))
							<div class="rounded-0">
								<ul class='list-unstyled'>
									<script>
										var toastHTML = '<span>{{ Session::get('errorMessage') }}</span>';
										M.toast({html: toastHTML, classes: 'rounded'});
									</script>
								</ul>
							</div>
						@endif
							
			@yield('user_body')
		</main>
	@include('../layouts/footer')
	</body>
<html>
