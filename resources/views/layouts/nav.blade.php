  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Logo</a>
      <ul class="right hide-on-med-and-down">
        @if(!isset($user))
          <li><a class="waves-effect waves-light btn-flat modal-trigger" href="#loginForm">Log In</a></li>
          @else
          <li><a class="waves-effect waves-light btn-flat modal-trigger" href="#logoutForm">Log Out</a></li>
        @endif
        <li><a class="waves-effect waves-light btn" href="register">Sign Up</a></li>
      </ul>

      <ul id="nav-mobile" class="sidenav">
        <li><a class="waves-effect waves-light btn-flat modal-trigger" href="#modal1">Log In</a></li>
        <li><a class="waves-effect waves-light btn" href= "register">Sign Up</a></li>
      </ul>
      <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
  </nav>

  <!-- Modal Structure -->
  <div id="loginForm" class="modal">
    <div class="modal-content">
      <h4>Log In</h4>
        <form action="{{url('login-user')}}" method="post">
        {{ csrf_field() }}
            <input type="email" name="login-email" id="login-email" placeholder="Email">
            <input type="password" name="login-password" id="login-password" placeholder="Password">
            <input type="submit" value="Login" class='btn'>
        </form>
    </div>
  </div>

  @if(isset($user))
  <div id="logoutForm" class="modal">
    <div class="modal-content">
      <h4>Log Out</h4>
      <p>Do you want to log out?</p>
        <form action="{{url('logout')}}" method="post">
          {{ csrf_field() }}
            <input type="hidden" name="_id" id="_id" value="{{ $user->_id }}">
            <input type="submit" value="Logout" class='btn'>
        </form>
      </div>
  </div>
  @endif
