@extends('../layouts/template')

@section('user_body')

  @foreach($blogPosts as $blogPost)
    @if($blogPost->isFeatured)
      <div class="section no-pad-bot" id="index-banner">
      <a href="get-blogpost/{{ $blogPost->_id }}">
      <img src="data:image/jpg;base64, {{$blogPost->photo}}" id="featured-article-img" class="no-pad-bot">
        <div class="container" id="blogPostHeading">
          <div class="row">
            <div class="col l6 m6 s12"></div>
            <div class="col l6 m6 s12">
              <div class="container">
                <div class="row">
                  <div class="col">
                    <p class="grey-text text-darken-1 left mt-5">FEATURED ARTICLE</p>
                  </div>
                  <div class="col">
                    <h3 class="header left grey-text text-darken-3 text-heavy">{{ $blogPost->title }}</h3>
                  </div>
                  <div class="col mt-2">
                    <a class="btn-large blue" href="get-blogpost/{{ $blogPost->_id }}">READ FOR FREE</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
         </a>
          </div>
        </div>
      </div>
    @endif
  @endforeach

 

  @if(!isset($user))
  <!-- require login for premium -->
    <div class="container mt-5">
      <div class="row">
    
        @foreach($blogPosts as $blogPost)
          @if($blogPost->isFeatured != true)
          <div class="col s12 l4 m6">
            <div class="card medium hoverable">
              <div class="card-image waves-effect waves-block waves-light">
                <img src="data:image/jpg;base64, {{$blogPost->photo}}" class="activator">
              </div>
              <div class="card-content">
                  @if($blogPost->isFree && $blogPost->isFeatured != true)
                    <p class="grey-text text-lighten-1 small-text">{{ strtoupper($blogPost->category) }}</p>
                  @else
                    <p class="orange-text text-lighten-1 small-text">PREMIUM</p>
                  @endif
                <span class="card-title activator grey-text text-darken-4">
                  <h6>{{ $blogPost->title }}<i class="material-icons right grey-text text-lighten-1">more_vert</i></h6>
                </span>
                <div class="card-action">
                  @if($blogPost->isFree && $blogPost->isFeatured != true)
                    <a href="{{ url('get-blogpost/' . $blogPost->_id) }}">Read Now</a>
                  @elseif($blogPost->isFree !== true)
                    <a class="modal-trigger" href="#loginForm">Read Now</a>
                  @endif
                </div>
              </div>
              <div class="card-reveal">
                <h6 class="card-title grey-text text-darken-4">{{ $blogPost->title }}<i class="material-icons right grey-text text-lighten-1">close</i></h6>
                <p>{{ substr($blogPost->synopsis, 0, 250) }}...</p>
                <div class="card-action">
                  @if($blogPost->isFree && $blogPost->isFeatured != true)
                    <a href="{{ url('get-blogpost/' . $blogPost->_id) }}">Keep Reading...</a></p>
                  @elseif($blogPost->isFree !== true)
                    <a class="modal-trigger" href="#loginForm">Keep Reading...</a></p>
                  @endif
                </div>
              </div>
            </div>
          </div>
          
          @endif
        @endforeach

      </div>
    </div>
  
  
  @else
  <!-- check if user plan is premium -->
    <div class="container mt-7" id="blogPostContainer">
      <div class="row">

        <!-- IF USER IS NOT ADMIN-->
        @if($user->isAdmin !== true)
          @foreach($blogPosts as $blogPost)
            @if($blogPost->isFeatured != true)
            <div class="col s12 l4 m6">
              <div class="card medium hoverable">
                <div class="card-image waves-effect waves-block waves-light">
                  <img src="data:image/jpg;base64, {{$blogPost->photo}}" class="activator">
                </div>
                <div class="card-content">
                    @if($blogPost->isFree)
                      <p class="grey-text text-lighten-1 small-text">{{ strtoupper($blogPost->category) }}</p>
                    @else
                      <p class="orange-text text-lighten-1 small-text">PREMIUM</p>
                    @endif
                  <span class="card-title activator grey-text text-darken-4">
                    <h6>{{ $blogPost->title }}<i class="material-icons right grey-text text-lighten-1">more_vert</i></h6>
                  </span>
                  <div class="card-action">
                    @if($blogPost->isFree)
                      <a href="{{ url('get-blogpost/' . $blogPost->_id) }}">Read Now</a>
                    @elseif($blogPost->isFree !== true && $user->plan == "free")
                    <!-- STRIPE -->
                      <a class="modal-trigger" href="#stripeForm">Read Now</a>
                    @elseif($blogPost->isFree !== true && $user->plan == "premium" )
                      <a href="blogpost-premium/{{ $blogPost->_id }}">Read Now</a>
                    @endif
                  </div>
                </div>
                <div class="card-reveal">
                  <h6 class="card-title grey-text text-darken-4">{{ $blogPost->title }}<i class="material-icons right grey-text text-lighten-1">close</i></h6>
                  <p>{{ substr($blogPost->synopsis, 0, 250) }}...</p>
                  <div class="card-action">
                    @if($blogPost->isFree)
                      <a href="{{ url('get-blogpost/' . $blogPost->_id) }}">Keep Reading...</a>
                    @elseif($blogPost->isFree !== true && $user->plan == "free")
                    <!-- STRIPE -->
                      <a class="modal-trigger" href="#stripeForm">Keep Reading...</a>
                    @elseif($blogPost->isFree !== true && $user->plan == "premium" )
                      <a href="blogpost-premium/{{ $blogPost->_id }}">Keep Reading...</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            
            @endif
          @endforeach
        
        <!-- IF USER IS ADMIN -->
        @else
          @foreach($blogPosts as $blogPost)
            @if($blogPost->isFeatured != true)

            <div class="col s12 l4 m6">
              <div class="card medium hoverable">
                <div class="card-image waves-effect waves-block waves-light">
                  <img src="data:image/jpg;base64, {{$blogPost->photo}}" class="activator">
                </div>
                <div class="card-content">
                    @if($blogPost->isFree)
                      <p class="grey-text text-lighten-1 small-text">{{ strtoupper($blogPost->category) }}</p>
                    @else
                      <p class="orange-text text-lighten-1 small-text">PREMIUM</p>
                    @endif
                  <span class="card-title activator grey-text text-darken-4">
                    <h6>{{ $blogPost->title }}<i class="material-icons right grey-text text-lighten-1">more_vert</i></h6>
                  </span>
                  <div class="card-action">
                    @if($blogPost->isFree)
                      <a href="{{ url('blogpost/' . $blogPost->_id) }}">Read or Edit</a>
                    @else
                      <a href="{{ url('blogpost-premium/' . $blogPost->_id) }}">Read or Edit</a>
                    @endif
                  </div>
                </div>
                <div class="card-reveal">
                  <h6 class="card-title grey-text text-darken-4">{{ $blogPost->title }}<i class="material-icons right grey-text text-lighten-1">close</i></h6>
                  <p>{{ substr($blogPost->synopsis, 0, 250) }}...</p>
                  <div class="card-action">
                    @if($blogPost->isFree)
                      <a href="{{ url('blogpost/' . $blogPost->_id) }}">Read or Edit</a>
                    @else
                      <a href="{{ url('blogpost-premium/' . $blogPost->_id) }}">Read or Edit</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            
            @endif
          @endforeach
        @endif

      </div>
    </div>
  @endif
  

@stop

