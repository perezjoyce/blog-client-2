@extends('../layouts/template')

@section('title', 'Dashboard')

@section('user_body')
	<div class="container">
		<div class="row">
			<div class="col">
            user dashboard ito
                <h1>{{ $user->user->name }}</h1>
                <h1>{{ $user->user->email }}</h1>
			</div>
		</div>
		<a class="waves-effect waves-light btn modal-trigger" href="#deleteForm">Delete</a>
	</div>
@endsection

<!-- Modal Structure -->
<div id="deleteForm" class="modal">
    <div class="modal-content">
	  <h4>Delete Account</h4>
	  	<p>Are you sure about this?</p>
        <form action="delete-user" method="post">
		@method('DELETE')
   		@csrf
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="submit" value="Confirm Deletion" class='btn'>
        </form>
    </div>
  </div>
