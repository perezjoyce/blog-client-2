@extends('../layouts/template')

@section('title', 'Dashboard')

@section('user_body')

  <div class="container">
    <div class="section">

      <!--   Blog Posts Section   -->
      <div class="row">
            <div class="col s12 m4"></div>

            <div class="col s12 m4">
                <div class="card">
                
                    <form action="create-user" method="post">
                    {{ csrf_field() }}
                        <input type="text" name="name" id="name" placeholder="name">
                        <input type="email" name="email" id="email" placeholder="email">
                        <input type="password" name="password" id="password" placeholder="password">
                        <input type="submit" value="Save">
                    </form>
                      
                </div>
            </div>

            <div class="col s12 m4"></div>
      </div>

    </div>
    <br><br>
  </div>

@endsection