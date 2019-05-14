@extends('../layouts/template')

@section('title', 'Profile')

@section('user_body')

	<div class="container mt-2">
		<div class="section">
			<p class="grey-text text-lighten-1">Name</p>
			<h5 class="grey-text text-darken-2">{{ $user->name }}</h5>
		</div>
		<div class="section">
			<p class="grey-text text-lighten-1">Email</p>
			<h5 class="grey-text text-darken-2">{{ $hiddenEmail }}</h5>
		</div>
		<div class="section">
			<p class="grey-text text-lighten-1">Subscription</p>
			<h5 class="grey-text text-darken-2">{{ ucfirst($user->plan) }}</h5>
		</div>
	</div>

	<a href="#editProfileForm" class="btn-floating btn-large waves-effect waves-light blue modal-trigger right" style="position:fixed;bottom:20px;right:100px;"><i class="material-icons">create</i></a>
	<a href="#deleteForm" class="btn-floating btn-large waves-effect waves-light red modal-trigger right" style="position:fixed;bottom:20px;right:20px;"><i class="material-icons">delete</i></a>

@stop

	<!-- Modal Structure -->
	<div id="deleteForm" class="modal">
		<div class="modal-content">
			<br>
			<h4>Account Deactivation</h4>
			<p>Please enter your credentials to confirm deactivation.</p>
			<br>
			<form action="delete-user" method="post">
				@csrf
				<div class="row">
					<div class="input-field">
						<input type="email" name="deactivation-email" id="deactivation-email" class="validate">
						<label for="deactivation-email">Email</label>
					</div>
					<div class="input-field">
						<input type="password" name="deactivation-password" id="deactivation-password" class="validate">
						<label for="deactivation-password">Password</label>
					</div>
				</div>
				<br>
				<button class="btn-large red waves-effect waves-light" type="submit" name="login">Deactivate
					<i class="material-icons right">delete</i>
				</button>
			</form>
		</div>
	</div>


	<!-- Modal Structure -->
	<div id="editProfileForm" class="modal">
		<div class="modal-content">
			<br>
			<h4>Edit Profile</h4>
			<br>
			<form action="edit-user" method="post">
				@csrf
				<div class="row">
					<input type="hidden" name="userId" id="userId" value="{{ $user->_id }}">
					<input type="hidden" name="edit_role" id="edit_role" value="false">
					<input type="hidden" name="edit_plan" id="edit_plan" value="{{ $user->plan }}">

					<div class="input-field">
						<input type="text" name="edit_name" id="edit_name" value="{{ $user->name }}" class="validate">
						<label for="edit_name">Name</label>
					</div>
					<div class="input-field">
						<input type="email" name="edit_email" id="edit_email" value="{{ $user->email }}" class="validate">
						<label for="edit_email">Email</label>
					</div>
				</div>
			
				<!-- <label>Subscription Plan</label>
				<select class="browser-default" name="edit_plan" id="edit_plan" required>
					<option value="{{ $user->plan }}" selected>{{ ucfirst($user->plan) }}</option>
					@if($user->plan === 'free')
						<option value="premium">Premium</option>
					@else
						<option value="free">Free</option>
					@endif
				</select> -->	
				<button class="btn blue waves-effect waves-light" type="submit" name="login">Apply Changes
					<i class="material-icons right">create</i>
				</button>
			</form>
			@if($user->plan == "free")
				<br>
				<p>Do you want to upgrade your subscription to Premium?</p>
				<a class="btn green waves-effect waves-light modal-trigger" href="#stripeForm">Upgrade
					<i class="material-icons right">subscriptions</i>
				</a>
			@endif
		</div>
	</div>

  