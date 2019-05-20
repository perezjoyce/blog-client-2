  <nav class="white z-depth-0" role="navigation" id="main-nav">
    <div class="nav-wrapper container">
      <a id="logo-container" class="left brand-logo grey-text text-darken-3" href="{{ url('/') }}">MAM</a>
        
      <!-- Large Screen -->
      @if(!isset($user))
        <a href="#" data-target="mobile" class="right sidenav-trigger grey-text text-darken-2 show-on-medium-and-down"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><a class="btn-flat modal-trigger grey-text text-darken-2" href="#loginForm">Log In</a></li>
          <li><a class="btn modal-trigger waves-effect waves-light blue" href="#registerForm">Sign Up</a></li>
        </ul>
        @else
        <a href="#" data-target="mobile" class="right sidenav-trigger grey-text text-darken-2 show-on-medium-and-down"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><a class="btn-flat modal-trigger grey-text text-darken-2" href="#logoutForm">Log Out</a></li>
          @if($user->isAdmin)
            <li><a class="btn-flat dropdown-trigger grey-text text-darken-2" href="#!" data-target="manage-sections">Manage<i class="material-icons right">arrow_drop_down</i></a></li>
            @else
            <li><a class="btn-flat grey-text text-darken-2" href="{{ url('dashboard') }}">Profile</a></li>
          @endif
        </ul>
      @endif

      <!-- Table and mobile -->
      <ul class="sidenav grey-text text-darken-3 show-on-medium-and-down" id="mobile">
        @if(isset($user))
            <li><a href="{{ url('dashboard') }}">Profile</a></li>
          @if($user->isAdmin)
            <li><a href="{{ url('blogposts') }}">Blog Posts</a></li>
            <li><a href="{{ url('users') }}">Users</a></li>
            <li class="divider"></li>
            <li><a href=" {{ url('write-blog-post') }}">Write New Blog</a></li>
            <li class="divider"></li>
          @endif
          <li><a class="modal-trigger grey-text text-darken-2" href="#logoutForm">Log Out</a></li>
        @else
          <li><a class="modal-trigger" href="#loginForm">Log In</a></li>
          <li><a class="modal-trigger" href="#registerForm">Sign Up</a></li>
        @endif
      </ul>
  
      <!-- Dropdown Structure -->
      <ul id="manage-sections" class="dropdown-content grey-text text-darken-3 show-on-large-only hide-on-med-and-down">
        <li><a href="{{ url('dashboard') }}">Profile</a></li>
        <li><a href="{{ url('blogposts') }}">Blog Posts</a></li>
        <li><a href="{{ url('users') }}">Users</a></li>
        <li class="divider"></li>
        <li><a href=" {{ url('write-blog-post') }}">Write New Blog</a></li>
      </ul>

    </div>
  </nav>


  <!-- Categories -->
  <nav class="blue-grey lighten-5 z-depth-0">
    <div class="container nav-wrapper center">
      <ul class="center hide-on-small-only">
        <li class="{{ url()->current() == 'http://localhost/blog-client/public/' ? 'active' : '' }} center"><a href="{{ url('/') }}" class="grey-text text-darken-2">All Blog Posts</a></li>
        <li class="{{ url()->current() == 'http://localhost/blog-client/public/category%201' ? 'active' : '' }} center"><a href="{{ url('blog-posts/category 1') }}" class="grey-text text-darken-2">Education</span></a></li>
        <li class="{{ url()->current() == 'http://localhost/blog-client/public/category%202' ? 'active' : '' }} center"><a href="{{ url('blog-posts/category 2') }}" class="grey-text text-darken-2">Web Dev</span></a></li>
        <li class="{{ url()->current() == 'http://localhost/blog-client/public/category%203' ? 'active' : '' }} center"><a href="{{ url('blog-posts/category 3') }}" class="grey-text text-darken-2">Mamahood</span></a></li>
        <li class="{{ url()->current() == 'http://localhost/blog-client/public/category%204' ? 'active' : '' }} center"><a href="{{ url('blog-posts/category 4') }}" class="grey-text text-darken-2">Training</span></a></li>
      </ul>
     
      <!-- Dropdown Version for small screen-->
      <a class="dropdown-trigger grey-text text-darken-2 left hide-on-med-and-up" href="#!" data-target="manage-categories">Categories<i class="material-icons right">arrow_drop_down</i></a>
      
      <ul id="manage-categories" class="dropdown-content grey-text text-darken-3  hide-on-med-and-up">
        <li class="{{ url()->current() == 'http://localhost/blog-client/public/' ? 'active' : '' }} center"><a href="{{ url('/') }}" class="grey-text text-darken-2">All Posts</a></li>
        <li class="{{ url()->current() == 'http://localhost/blog-client/public/category%201' ? 'active' : '' }} center"><a href="{{ url('/category 1') }}" class="grey-text text-darken-2">Education</span></a></li>
        <li class="{{ url()->current() == 'http://localhost/blog-client/public/category%202' ? 'active' : '' }} center"><a href="{{ url('/category 2') }}" class="grey-text text-darken-2">Web Dev</span></a></li>
        <li class="{{ url()->current() == 'http://localhost/blog-client/public/category%203' ? 'active' : '' }} center"><a href="{{ url('/category 3') }}" class="grey-text text-darken-2">Mamahood</span></a></li>
      </ul>
    </div>
  </nav>

  <!-- MODALS -->
  <div id="loginForm" class="modal">
    <div class="modal-content">
        <br>
        <h4>Log In</h4>
        <p>Please enter your login credentials.</p>
        <br>
        <form action="{{url('login-user')}}" method="post">
          {{ csrf_field() }}
          <div class="row">
            <div class="input-field">
              <input type="email" name="login-email" id="login-email" class="validate">
              <label for="login-email">Email</label>
            </div>
            <div class="input-field">
              <input type="password" name="login-password" id="login-password" class="validate">
              <label for="login-password">Password</label>
            </div>
            <br>
          </div>
          <button class="btn-large blue waves-effect waves-light" type="submit" name="login">Login
            <i class="material-icons right">exit_to_app</i>
          </button>
        </form>
    </div>
  </div>

 
  <div id="registerForm" class="modal">
    <div class="modal-content" id="register-modal">
      <br>
      <h4>Sign Up</h4>
      <form action="{{url('create-user')}}" method="post">
        {{ csrf_field() }}
        <div class="row">

          <div class="input-field">
            <input type="text" name="name" id="name" class="validate">
            <label for="name">Name</label>
          </div>
      
          <div class="input-field">
            <input type="email" name="email" id="email" class="validate">
            <label for="name">Email</label>
          </div>

          <div class="input-field">
            <input type="password" name="password" id="password" class="validate" minlength="6">
            <label for="password">Password</label>
          </div>

          <br>
          
          <button class="btn-large blue waves-effect waves-light" type="submit" name="action">Join MAM!</button>
        </div>
      </form>
    </div>
  </div>

  @if(isset($user))
  <div id="logoutForm" class="modal">
    <div class="modal-content">
        <br>
        <h4>Log Out</h4>
        <br>
        <p>Do you want to be logged out of this webiste?</p>
        <form action="{{url('logout')}}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="_id" id="_id" value="{{ $user->_id }}">
          <br>
          <button class="btn-large blue waves-effect waves-light" type="submit" name="logout">Yes, Please.
            <i class="material-icons right">power_settings_new</i>
          </button>
        </form>
      </div>
  </div>
  @endif

	<div id="stripeForm" class="modal">
		<div class="modal-content">
			<br>
			<h4>Upgrade Subscription</h4>
			<br>
			<p>Read premium articles & get freebies!</p>
			<br>
			<form action="{{ url('subscription')}}" method="post" id="payment-form">
				@csrf
				<div class="row form-row">
					<div class="input-field">
						<div id="card-element">
							<!-- A Stripe Element will be inserted here. -->
						</div>
					</div>
					
					<!-- Used to display Element errors. -->
					<div id="card-errors" role="alert"></div>
				</div>

				<br>
				<button class="btn-large blue waves-effect waves-light" type="submit" name="login">Submit Payment
					<i class="material-icons right">send</i>
				</button>
			</form>
		</div>
  </div>