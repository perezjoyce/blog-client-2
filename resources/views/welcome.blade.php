@extends('../layouts/template')

@section('user_body')

    @if(Session::has("successMessage"))
	<div class="alert alert-success">
		{{ Session::get('successMessage') }}
	</div>
	@elseif(Session::has("errorMessage"))
	<div class="alert alert-danger">
		{{ Session::get('errorMessage') }}
	</div>
	@endif

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
    <div class="row">
      @foreach($blogPosts as $blogPost)
        @if($blogPost->isFree === true)
          <div class="col s12 m4 l4">
          <br><br>
              <div class="card">
                  <div class="card-image">
                      <img src="images/sample-1.jpg">
                      <span class="card-title">{{ $blogPost->title }}</span>
                  </div>
                  <div class="card-content">
                    <p>{{ $blogPost->isFree }}</p>
                      <p>{{ $blogPost->synopsis }}</p>
                  </div>
                  <a href="get-blogpost/{{ $blogPost->_id }}">Read</a>
              </div>
          </div>
        @endif
      @endforeach
    </div>
  </div>
@stop