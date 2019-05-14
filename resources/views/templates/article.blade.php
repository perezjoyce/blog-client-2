@extends('../layouts/template')

@section('title', 'Dashboard')

@section('user_body')

	@if($blogPost->isFree || $blogPost->isFeatured)
	<div class="section no-pad-bot" id="index-banner">
        <div class="container">
          <div class="row">
            <div class="col l6 m6 s12">
              <img src="data:image/jpg;base64, {{$blogPost->photo}}" id="featured-article-img">
            </div>
            <div class="col l6 m6 s12">
              <div class="container">
                <div class="row">
                  <div class="col s12">
                      <p class="grey-text text-darken-1 left mt-5">
                        {!!strtoupper($blogPost->category)!!}
                      </p>
                  </div>
                  <div class="col s12">
                    <h3 class="header left grey-text text-darken-3 text-heavy">{{ $blogPost->title }}</h3>
                  </div>
                  <div class="col s12">
				            <h6 class="header col s12 grey-text text-darken-2">{{ $blogPost->author }} &nbsp;|&nbsp; {{ date('F j, Y', strtotime($blogPost->createdAt)) }}</h5> 
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>

		<!-- BODY -->
		<div class="container mt-2">
			<div class="row">
        <div class="col l1"></div>
				<div class="col s12 m12 l10">
						{!! $blogPost->body !!}  
        </div>
        <div class="col l1"></div>
			</div>
		</div>
  @endif
  
  @if(isset($user) && $user->isAdmin)
    <a href="{{url('edit-blogpost/' . $blogPost->_id)}}" class="btn-floating btn-large waves-effect waves-light blue modal-trigger right" style="position:fixed;bottom:20px;right:20px;"><i class="material-icons">create</i></a>
  @endif
@endsection   