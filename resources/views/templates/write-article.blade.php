@extends('../layouts/template')

@section('title', 'Write New Blog')

@section('user_body')

	@if($user->isAdmin)
		<div class="container mt-5">
			<div class="row">

					<form action="{{ url('create-blog-post') }}" method="post" id="post-form" class="col-12" enctype="multipart/form-data">
					@csrf
						<div class="form-group">
							<div class="input-field col s12 m6 l6">
								<input type="text" name="author" id="author" class="validate">
								<label for="author">Author</label>
							</div>
							<div class="input-field col s12 m6 l6">
								<input type="text" name="title" id="title" class="validate">
								<label for="title">Title</label>
							</div>
						</div>
						<div class="row">
							<div class="col s12 m4 l3">
								<label>Category</label>
								<select class="browser-default" name="category" id="category" required>
									<option value="category 1" selected disabled>Choose A Category</option>
									<option value="category 1">Category 1</option>
									<option value="category 2">Category 2</option>
									<option value="category 3">Category 3</option>
									<option value="category 4">Category 4</option>
								</select>
							</div>
							<div class="col l1"></div>
								<div class="col s12 m8 l8">
									<div class="row">
										<div class="col s4 l4 m4">
											<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">Set As Featured</p>
											<label>
												<input type="checkbox" id="isFeatured" name="isFeatured"/>
												<span>Yes</span>
											</label>
										</div>
										<div class="col s4 l4 m4">
											<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">Plan</p>
											<label>
												<input class="with-gap" name="isFree" type="radio" value="true" checked/>
												<span>Free</span>
											</label>
											<br>
											<label>
												<input class="with-gap" name="isFree" type="radio" value="false" />
												<span>Paid</span>
											</label>
										</div>
										<div class="col s4 l4 m4">
											<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">Status</p>
											<label>
											<input class="with-gap" name="status" type="radio" value="draft" checked/>
												<span>Draft</span>
											</label>
											<br>
											<label>
											<input class="with-gap" name="status" type="radio" value="final" />
												<span>Final</span>
											</label>
										</div>
									</div>
								</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<textarea name="synopsis" id="synopsis" class="materialize-textarea" data-length="250"></textarea>
								<label for="textarea1">Synopsis</label>
							</div>
						</div>
						<script>
							$(document).ready(function() {
								$('textarea#synopsis').characterCounter();
							});
						</script>

						<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">Cover photo</p>
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
						
						<br>
						<p class="label-text" style="font-size: 0.8rem;color: #9e9e9e;">Blog Content</p>
						<div class="row">
							<div class='col s12 card-panel hoverable'>
								<br><br>
								<div class="container">
									<div class="row dfree-body" id='body' name="body">
									<h2>The world’s first rich text editor in the cloud</h2>
											<p>
											Have you heard about Tiny Cloud? 
											It’s the first step in our journey to help you deliver great content creation experiences, no matter your level of expertise. 
											50,000 developers already agree. 
											They get free access to our global CDN, image proxy services and auto updates to the TinyMCE editor. 
											They’re also ready for some exciting updates coming soon.
											</p>


											<p>
											One of these enhancements is <strong>Tiny Drive</strong>: imagine file management for TinyMCE, in the cloud, made super easy. 
											Learn more at <a href='https://www.tiny.cloud/tinydrive/'>tiny.cloud/tinydrive</a>, where you’ll find a working demo and an opportunity to provide feedback to the product team.
											</p>

											<h3>An editor for every project</h3>

											<p>
											Here are some of our customer’s most common use cases for TinyMCE:
											<ul>
												<li>Content Management Systems (<em>e.g. WordPress, Umbraco</em>)</li>
												<li>Learning Management Systems (<em>e.g. Blackboard</em>)</li>
												<li>Customer Relationship Management and marketing automation (<em>e.g. Marketo</em>)</li>
												<li>Email marketing (<em>e.g. Constant Contact</em>)</li>
												<li>Content creation in SaaS systems (<em>e.g. Eventbrite, Evernote, GoFundMe, Zendesk</em>)</li>
											</ul>
											</p>

											<p>
											And those use cases are just the start. 
											TinyMCE is incredibly flexible, and with hundreds of APIs there’s likely a solution for your editor project. 
											If you haven’t experienced Tiny Cloud, get started today. 
											You’ll even get a free trial of our premium plugins – no credit card required!
									</div>
								</div>
								<br>
							</div>
						</div>
							
						<textarea name="body" style="display:none" id="postBody"></textarea>
				
						<br><br>
						<a class='btn-large modal-trigger blue' id="submitHandler">Save Blog Post
							<i class="material-icons right">save</i>
						</a>
					</form>
				</div>
		</div>
	@endif

@endsection  

							
						
						