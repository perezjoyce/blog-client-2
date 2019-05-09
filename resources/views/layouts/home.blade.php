@extends('../layouts/template')

@section('title', 'Dashboard')

@section('user_body')

  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <h1 class="header center orange-text">Featured Blog Title</h1>
      <div class="row center">
        <h5 class="header col s12 light">Truncated synopsis...</h5>
      </div>
      <div class="row center">
        <a href="http://materializecss.com/getting-started.html" id="download-button" class="btn-large waves-effect waves-light orange">Get Started</a>
      </div>
      <br><br>

    </div>
  </div>

  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="images/sample-1.jpg">
                        <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                        <a href="#">This is a link</a>
                    </div>
                </div>
            </div>

            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="images/sample-1.jpg">
                        <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                        <a href="#">This is a link</a>
                    </div>
                </div>
            </div>


            <div class="col s12 m4">
                <div class="card">
                    <div class="card-image">
                        <img src="images/sample-1.jpg">
                        <span class="card-title">Card Title</span>
                    </div>
                    <div class="card-content">
                        <p>I am a very simple card. I am good at containing small bits of information.
                        I am convenient because I require little markup to use effectively.</p>
                    </div>
                    <div class="card-action">
                        <a href="#">This is a link</a>
                    </div>
                </div>
            </div>

        

        
      </div>

    </div>
    <br><br>
  </div>
@endsection