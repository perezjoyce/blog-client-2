@extends('../layouts/template')

@section('user_body')

    @if($user->isAdmin)
        <div class="container">
            <br><br>
            <div class="row">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Plan</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($blogUsers as $blogUser)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ ucwords($blogUser->name) }}</td>
                        <td>{{ $blogUser->email }}</td>
                        <td>{{ $blogUser->isAdmin === true ? "Admin" : "User" }}</td>
                        <td>{{ ucfirst($blogUser->status) }}</td>
                        <td>{{ ucfirst($blogUser->plan) }}</td>
                        <td>{{ date('F j, Y', strtotime($blogUser->createdAt)) }}</td>
                        <td>
                            <a class="waves-effect waves-light btn blue modal-trigger" 
                                id='editUserTrigger' 
                                href="#editProfileForm" 
                                data-id='{{ $blogUser->_id }}'
                                data-name="{{ $blogUser->name }}"
                                data-email="{{ $blogUser->email }}"
                                data-role="{{ $blogUser->isAdmin }}"
                                data-plan="{{ $blogUser->plan }}"
                                >EDIT</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    @endif
@stop


    <!-- Modal Structure -->
<div id="editProfileForm" class="modal">
    <br>
    <div class="modal-content">
      <h4>Edit Profile</h4>
      <br>
        <form action="edit-user" method="post">
        @csrf
            <label>Username</label>
            <input type="hidden" name="userId" id="userId">
			<input type="hidden" name="edit_name" id="edit_name">
            <input type="hidden" name="edit_email" id="edit_email">
            
            <label>Role</label>
			<select class="browser-default" name="edit_role" id="edit_role">
			</select>
            <br>
            
			<label>Subscription Plan</label>
			<select class="browser-default" name="edit_plan" id="edit_plan">
            </select>
            
			<br>

            <button class="btn-large blue waves-effect waves-light" type="submit" id="saveUserChanges">Apply Changes
            </button>
        </form>
    </div>
  </div>

