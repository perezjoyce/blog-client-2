@extends('../layouts/template')

@section('title', 'Dashboard')

@section('user_body')
<br><br>
    <div class="container">
        <div class="row">
            <div class="col">
                @if(Session::has("successMessage"))
                <div class="alert alert-success">
                    {{ Session::get('successMessage') }}
                </div>
                @elseif(Session::has("errorMessage"))
                <div class="alert alert-danger">
                    {{ Session::get('errorMessage') }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <form action="{{ url('save-blogpost-edits/' . $blogPost->_id) }}" method='post' id="saveBlogPostEditsForm"> 
                    @csrf
                    <div class="form-group">
                        <input type="text" name="author" id="author" value="{{ $blogPost->author ? $blogPost->author : 'Joyce Perez' }}">
                        <input type="text" name="title" id="title" value="{{ $blogPost->title }}" required>
                        <select class="browser-default" name="category" id="category" required>
                            <option value="category 1" {{ $blogPost->category === "category 1" ? "selected" : "" }}>Category 1</option>
                            <option value="category 2" {{ $blogPost->category === "category 2" ? "selected" : "" }}>Category 2</option>
                            <option value="category 3" {{ $blogPost->category === "category 3" ? "selected" : "" }}>Category 3</option>
                            <option value="category 4" {{ $blogPost->category === "category 4" ? "selected" : "" }}>Category 4</option>
                        </select>
                        <select class="browser-default" name="isFree" id="isFree" required>
                            <option value="true" {{ $blogPost->isFree ? "selected" : "" }}>Free</option>
                            <option value="false" {{ $blogPost->isFree === false ? "selected" : "" }}>Paid</option>
                        </select>
                        <select class="browser-default" name="status" id="status" required>
                            <option value="draft" {{ $blogPost->status === "draft" ? "selected" : "" }}>Draft</option>
                            <option value="final" {{ $blogPost->status === "final" ? "selected" : "" }}>Final</option>
                        </select>
                        <textarea name="synopsis" id="synopsis" cols="30" rows="10">{{ $blogPost->synopsis }}</textarea>
                
                        <div class='dfree-body' id='body' name='body'>
                            {!! $blogPost->body !!}
                        </div>
                    </div>
                    <a id="submitBlogPostEdits" class='btn modal-trigger' href="#saveBlogPostEdits">Save Changes</a>
                </form>
            </div>
        </div>
    </div>
@endsection   


<!-- Modal Structure -->
<div id="saveBlogPostEdits" class="modal">
    <div class="modal-content">
	  <h4>Save Edits</h4>
          <p>Do you want to save the changes you made to {{$blogPost->title}}?</p>
          <a href="#" class="waves-effect waves-light btn saveEditsBtn">Save</a>
          <a href="#" class="waves-effect waves-light btn cancelEditsBtn">Cancel</a>
    </div>
  </div>