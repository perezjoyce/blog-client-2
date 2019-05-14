@extends('../layouts/template')

@section('title', 'User List')

@section('user_body')
    @if($user->isAdmin)
      <div class="container mt-2">
          <br><br>
        <div class="row">
          <table class="responsive-table">
            <thead>
              <tr class="grey-text text-darken-2">
                  <th>#</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Status</th>
                  <th>Action</th>
              </tr>
            </thead>

            <tbody>
              @foreach($blogPosts as $blogPost)
                <tr class="grey-text text-darken-1">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ substr($blogPost->title, 0, 20) }}</td>
                    <td>{{ $blogPost->author }}</td>
                    <td>{{ date('F j, Y', strtotime($blogPost->createdAt)) }}</td>
                    <td>{{ date('F j, Y', strtotime($blogPost->updatedAt)) }}</td>
                    <td>{{ ucfirst($blogPost->status) }}</td>
                    <td>
                        <a class="waves-effect waves-light btn blue" 
                            href="{{ url('get-blogpost/' . $blogPost->_id) }}"><i class="material-icons">create</i></a>
                           

                        <a class="waves-effect waves-light btn modal-trigger btn red deleteBlogTrigger" 
                            href="#deleteBlog" 
                            data-id='{{ $blogPost->_id }}'
                            data-title="{{ $blogPost->title }}"
                            data-author="{{ $blogPost->author }}"
                            data-createdat="{{ date('F j, Y', strtotime($blogPost->createdAt)) }}"
                            ><i class="material-icons">delete</i></a>
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif
@stop

<!-- DELETE BLOG -->
@if($user->isAdmin)
  <div id="deleteBlog" class="modal">
    <div class="modal-content">
      <br>
      <h4>Delete Blog Post</h4>
      <br>
      <div>Do you want to delete the following blog post?</div>
      <div>This action cannot be undone.</div>
      <br>
      <h6 class="red-text heavy-text" id="blogTitleToDelete"></h6>
      <div class="grey-text text-darken-1" id="blogAuthorToDelete"></div>
      <div class="grey-text text-darken-1" id="blogCreatedAtToDelete"></div>
      <br>
        <form action="{{ url('delete-blogpost') }}" method="post" id='deleteBlogForm'>
           @csrf
            <input type="hidden" id="deleteBlogId" name='deleteBlogId'>
            <input type="hidden" id="deleteBlogTitle" name='deleteBlogTitle'>
            <br>
            <button class="btn-large red waves-effect waves-light" type="submit">Delete
              <i class="material-icons right">delete</i>
            </button>
        </form>
    </div>
  </div>
@endif

