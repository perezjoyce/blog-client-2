<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Session;
use Redirect;
use function GuzzleHttp\json_encode;
use Symfony\Component\HttpFoundation\File\File;

class BlogPostController extends Controller
{   

    public function displayHomePage(Request $request) {

        // $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q4ZTk0NDUwNjM4MDI3YjAzOWIwYWQiLCJpYXQiOjE1NTc3MTkzNjR9.GgLecg32XQxU5dzo6zIGLfFAJN8NGbelb7YI4qx8Wm0';
        $token = $request->session()->get('token');    

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  =>2.0,
            'headers' => $headers
        ]);
            
        $response = $client->get('/finalBlogPosts');
        $blogPosts = json_decode($response->getBody());

        try {
            $userId = Session::get('_id');
            $response2 = $client->get('/users/'. $userId);
            $user = json_decode($response2->getBody());
            return view('welcome')->with(compact('blogPosts', 'user'));
        } catch (\Exception $e) {

            return view('welcome')->with(compact('blogPosts'));
        }
        
    }


    public function displayAllBlogPosts(Request $request) {

        // $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q4ZTk0NDUwNjM4MDI3YjAzOWIwYWQiLCJpYXQiOjE1NTc3MTkzNjR9.GgLecg32XQxU5dzo6zIGLfFAJN8NGbelb7YI4qx8Wm0';
    
        $token = $request->session()->get('token');    

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  =>2.0,
            'headers' => $headers
        ]);

        $userId = Session::get('_id');

        if(isset($userId)) {
            $response2 = $client->get('/users/'. $userId);
            $user = json_decode($response2->getBody());
            $response = $client->get('/allBlogPosts');
            $blogPosts = json_decode($response->getBody());
            return view('templates.article-list')->with(compact('blogPosts', 'user'));
        } else {
            $response = $client->get('/finalBlogPosts');
            $blogPosts = json_decode($response->getBody());
            return view('welcome')->with(compact('blogPosts'));
        }
    }


    public function getBlogPost(Request $request, $blogPostId) {

        // $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q4ZTk0NDUwNjM4MDI3YjAzOWIwYWQiLCJpYXQiOjE1NTc3MTkzNjR9.GgLecg32XQxU5dzo6zIGLfFAJN8NGbelb7YI4qx8Wm0';
        $token = $request->session()->get('token');    

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);

        $userId = Session::get('_id');

        if(!isset($userId)) {
            return redirect('/blogpost/' . $blogPostId);
        } else {

            $response = $client->get('/users/'. $userId);
            $user = json_decode($response->getBody());

            if($user->isAdmin) {
                return redirect('/edit-blogpost/' . $blogPostId);
            }

            if ($user->plan === 'premium') {
                return redirect('/blogpost-premium/' . $blogPostId);
            }

            return redirect('/blogpost/' . $blogPostId);
        }
    }

    public function displayBlogPost(Request $request, $blogPostId){

        // $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q4ZTk0NDUwNjM4MDI3YjAzOWIwYWQiLCJpYXQiOjE1NTc3MTkzNjR9.GgLecg32XQxU5dzo6zIGLfFAJN8NGbelb7YI4qx8Wm0';
        $token = $request->session()->get('token');    

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);

        $response = $client->get('/blogPosts/' . $blogPostId);

        $blogPost = json_decode($response->getBody());

        try {
            $userId = Session::get('_id');
            $response = $client->get('/users/'. $userId);
            $user = json_decode($response->getBody());
            return view('templates.article')->with(compact('blogPost', 'user'));
        } catch (\Exception $e) {
            return view('templates.article')->with(compact('blogPost'));
        }

    }

    public function displayPremiumBlogPost(Request $request, $blogPostId){
        
        // $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q4ZTk0NDUwNjM4MDI3YjAzOWIwYWQiLCJpYXQiOjE1NTc3MTkzNjR9.GgLecg32XQxU5dzo6zIGLfFAJN8NGbelb7YI4qx8Wm0';
        $token = $request->session()->get('token');    

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);
        
        $response = $client->get('/blogPosts/' . $blogPostId);

        $blogPost = json_decode($response->getBody());

        try {
            $userId = Session::get('_id');
            $response2 = $client->get('/users/'. $userId);
            $user = json_decode($response2->getBody());
            return view('templates.article-premium')->with(compact('blogPost', 'user'));
        } catch (\Exception $e) {
            return view('templates.article-premium')->with(compact('blogPost'));
        }
    }

    public function writeBlogPostForm(Request $request) {
        // $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q4ZTk0NDUwNjM4MDI3YjAzOWIwYWQiLCJpYXQiOjE1NTc3MTkzNjR9.GgLecg32XQxU5dzo6zIGLfFAJN8NGbelb7YI4qx8Wm0';
        $token = $request->session()->get('token');    
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);

        $userId = Session::get('_id');
        $response = $client->get('/users/'. $userId);
        $user = json_decode($response->getBody());
        
        return view('templates.write-article')->with(compact('user'));
    }

    public function createBlogPost(Request $request) {

        $token = $request->session()->get('token');    
        $blogPostData = [
            'author' => $request->input('author'),
            'title' => $request->input('title'),
            'synopsis' => $request->input('synopsis'),
            'category' => $request->input('category'),
            'isFree' => $request->input('isFree') === "true" ? true : false,
            'isFeatured' => $request->input('isFeatured') == "on" ? true : false,
            'status' => $request->input('status'),
            'body' => html_entity_decode($request->input('body'))
        ];
        
        $userId = Session::get('_id');

        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 5.0,
            'headers' => $headers
        ]);
        
        $response = $client->post('/blogPosts', [
            'json' => $blogPostData
        ]);

        $blogPost = json_decode($response->getBody());

        // $userReponse = $client->get('/users/'. $userId);
        // $user = json_decode($userReponse->getBody());

        try {

            $contents = file_get_contents($request->photo->path());

            $client2 = new Client([
                'base_uri' => 'http://127.0.0.1:3000',
                'timeout'  => 5.0,
                'headers' => $headers
            ]);
    
            $client2->request('POST', '/blogPosts/' . $blogPost->_id . '/photo', [
                'multipart' =>  [
                    [
                        'name'     => 'photo',
                        'contents' => $contents,
                        'filename' => $request->file('photo')->getClientOriginalName()
                    ]
                ]
            ]);
    
            Session::flash("successMessage", "Blog post has been successfully saved!");
            return redirect('get-blogpost/'. $blogPost->_id);
        } catch (\Exception $e) {
            Session::flash("errorMessage", "ERROR: File is too large!");
            return Redirect::back();
        }

    }

    public function deleteBlogPost(Request $request){
        $blogPostId = $request->input('deleteBlogId');
        $blogPostTitle = $request->input('deleteBlogTitle');
        // $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q4ZTk0NDUwNjM4MDI3YjAzOWIwYWQiLCJpYXQiOjE1NTc3MTkzNjR9.GgLecg32XQxU5dzo6zIGLfFAJN8NGbelb7YI4qx8Wm0';
        $token = $request->session()->get('token');    
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);
        
        $client->delete('blogPosts/'.$blogPostId);
        Session::flash("successMessage", $blogPostTitle . " has been successfully deleted.");
        return Redirect::back();
    }

    public function editBlogPostForm(Request $request, $blogPostId){
      
        // $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q4ZTk0NDUwNjM4MDI3YjAzOWIwYWQiLCJpYXQiOjE1NTc3MTkzNjR9.GgLecg32XQxU5dzo6zIGLfFAJN8NGbelb7YI4qx8Wm0';
        $token = $request->session()->get('token');    
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);

        $response = $client->get('/blogPosts/' . $blogPostId);
        $blogPost = json_decode($response->getBody());

        $userId = Session::get('_id');
        $response2 = $client->get('/users/'. $userId);
        $user = json_decode($response2->getBody());
        
        return view('templates.edit-article')->with(compact('blogPost', 'user'));
    }

    public function saveBlogPostEdits(Request $request, $blogPostId) {

        $token = $request->session()->get('token'); 
        $blogPostData = [
            'author' => $request->input('author'),
            'title' => $request->input('title'),
            'synopsis' => $request->input('synopsis'),
            'category' => $request->input('category'),
            'isFree' => $request->input('isFree') === "true" ? true : false,
            'isFeatured' => $request->input('isFeatured') == "on" ? true : false,
            'status' => $request->input('status'),
            'body' => html_entity_decode($request->input('body'))
        ];
   
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 5.0,
            'headers' => $headers
        ]);

        $response = $client->patch('/blogPosts/' . $blogPostId, [
            'json' => $blogPostData
        ]);

        if(!$request->photo) {
     
            Session::flash("successMessage", "Changes have been successfully saved!");
            return Redirect::back();

        } else {

            try {
                $blogPost = json_decode($response->getBody());

                $contents = file_get_contents($request->photo->path());
    
                $client2 = new Client([
                    'base_uri' => 'http://127.0.0.1:3000',
                    'timeout'  => 5.0,
                    'headers' => $headers
                ]);
    
                $client2->request('POST', '/blogPosts/' . $blogPost->_id . '/photo', [
                    'multipart' =>  [
                        [
                            'name'     => 'photo',
                            'contents' => $contents,
                            'filename' => $request->file('photo')->getClientOriginalName()
                        ]
                    ]
                ]);
    
                Session::flash("successMessage", "Changes have been successfully saved!");
                return Redirect::back();
            } catch (\Exception $e) {
                Session::flash("errorMessage", "ERROR: File is too large!");
                return Redirect::back();
            }

            
        }
    }
    
}
