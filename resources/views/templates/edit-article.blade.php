@extends('../layouts/template')

@section('title', 'Edit Blog')

@section('user_body')
    <div class="container mt-5">
        <div class="row">
            
			<form action="{{ url('save-blogpost-edits/' . $blogPost->_id) }}" method="post" id="save-form" class="col-12" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<div class="input-field col s12 m6 l6">
						<input type="text" name="author" id="author" value="{{ $blogPost->author }}" class="validate">
						<label for="author">Author</label>
					</div>
					<div class="input-field col s12 m6 l6">
						<input type="text" name="title" id="title" value="{{ $blogPost->title }}" class="validate">
						<label for="title">Title</label>
					</div>
				</div>
				<div class="row">
					<div class="col s12 m4 l3">
						<label>Category</label>
						<select class="browser-default" name="category" id="category" required>
							<option value="category 1" {{ $blogPost->category === "category 1" ? "selected" : "" }}>Category 1</option>
							<option value="category 2" {{ $blogPost->category === "category 2" ? "selected" : "" }}>Category 2</option>
							<option value="category 3" {{ $blogPost->category === "category 3" ? "selected" : "" }}>Category 3</option>
							<option value="category 4" {{ $blogPost->category === "category 4" ? "selected" : "" }}>Category 4</option>
						</select>
					</div>
					<div class="col l1"></div>
					<div class="col s12 m8 l8">
						<div class="row">
							<div class="col s4 l4 m4">
								<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">Set As Featured</p>
								<label>
									<input type="checkbox" name="isFeatured" {{ $blogPost->isFeatured ? "checked" : "" }}/>
									<span>Yes</span>
								</label>
							</div>
							<div class="col s4 l4 m4">
								<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">Plan</p>
								<label>
									<input class="with-gap" name="isFree" type="radio" value="true" {{ $blogPost->isFree === true ? "checked" : "" }}/>
									<span>Free</span>
								</label>
								<br>
								<label>
									<input class="with-gap" name="isFree" type="radio" value="false" {{ $blogPost->isFree === false ? "checked" : "" }}/>
									<span>Paid</span>
								</label>
							</div>
							<div class="col s4 l4 m4">
								<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">Status</p>
								<label>
									<input class="with-gap" name="status" type="radio" value="draft" {{ $blogPost->status === "draft" ? "checked" : "" }}/>
									<span>Draft</span>
								</label>
								<br>
								<label>
									<input class="with-gap" name="status" type="radio" value="final" {{ $blogPost->status === "final" ? "checked" : "" }}/>
									<span>Final</span>
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<textarea name="synopsis" id="synopsis" class="materialize-textarea" data-length="250">{{$blogPost->synopsis}}</textarea>
						<label for="textarea1">Synopsis</label>
					</div>
				</div>
				<script>
					$(document).ready(function() {
						$('textarea#synopsis').characterCounter();
					});
				</script>

				<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">{{ $blogPost->photo == "AA==" ? "Add " : "Change "}} cover photo</p>
				<div class="file-field input-field">
					<div class="btn">
						<span>File</span>
						<input type="file" name="photo">
						<i class="material-icons right">file_upload</i>
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text">
					</div>
				</div>
				
				@if($blogPost->photo !== "AA==")
				<div class="row">
					<img src="data:image/jpg;base64, {{$blogPost->photo}}" id="featured-article-img" class="no-pad-bot">
				</div>
				@endif
			
				<br>
					
				<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">Blog Content</p>
				<div class="row">
					<div class='col s12 card-panel hoverable'>
						<br><br>
						<div class="container">
							<div class="row dfree-body" id='body' name="body">
								{!! $blogPost->body !!}
							</div>
						</div>
						<br>
					</div>
				</div>
					
				<textarea name="body" style="display:none" id="postBody"></textarea>
		
				<br><br>
				<a id="submitBlogPostEdits" class='btn-large modal-trigger blue' href="#saveBlogPostEdits">Save Changes
					<i class="material-icons right">save</i>
				</a>
			</form>
      
        </div>
    </div>
@endsection   


<!-- Modal Structure -->
<div id="saveBlogPostEdits" class="modal">
	<div class="modal-content">
		<br>
		<h4>Save Edits</h4>
		<br>
			<p>Do you want to save the changes you made to {{$blogPost->title}}?</p>
		<br>
			<a href="#" class="waves-effect waves-light btn-large blue saveEditsBtn">Yes!<i class="material-icons right">save</i></a>
			<a href="#" class="waves-effect waves-light btn-large red cancelEditsBtn">No</a>
	</div>
</div>