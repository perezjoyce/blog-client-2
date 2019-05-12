<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Session;
use Redirect;

class BlogPostController extends Controller
{   

    public function displayAllBlogPosts() {

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q0YjI4ZWEyNDk5YjBhZDA2YWE3NTkiLCJpYXQiOjE1NTc0NDMyMTR9.3UZ9hFtBtWgO5J5IG8Ftg85l-mwBIFxr_sVXQMfKwx4';
    
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

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q0YjI4ZWEyNDk5YjBhZDA2YWE3NTkiLCJpYXQiOjE1NTc0NDMyMTR9.3UZ9hFtBtWgO5J5IG8Ftg85l-mwBIFxr_sVXQMfKwx4';
        
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

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q0YjI4ZWEyNDk5YjBhZDA2YWE3NTkiLCJpYXQiOjE1NTc0NDMyMTR9.3UZ9hFtBtWgO5J5IG8Ftg85l-mwBIFxr_sVXQMfKwx4';
    
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

        return view('templates.article')->with(compact('blogPost'));
    }

    public function displayPremiumBlogPost(Request $request, $blogPostId){
        
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q0YjI4ZWEyNDk5YjBhZDA2YWE3NTkiLCJpYXQiOjE1NTc0NDMyMTR9.3UZ9hFtBtWgO5J5IG8Ftg85l-mwBIFxr_sVXQMfKwx4';
    
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
        return view('templates.article-premium')->with(compact('blogPost', 'user'));
    }

    public function createBlogPost(Request $request) {
        $blogPostData = [
            'author' => $request->input('author'),
            'title' => $request->input('title'),
            'synopsis' => $request->input('synopsis'),
            'category' => $request->input('category'),
            'isFree' => $request->input('isFree'),
            'status' => $request->input('status'),
            'body' => $request->input('body')
        ];

        $userId = Session::get('_id');

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q0YjI4ZWEyNDk5YjBhZDA2YWE3NTkiLCJpYXQiOjE1NTc0NDMyMTR9.3UZ9hFtBtWgO5J5IG8Ftg85l-mwBIFxr_sVXQMfKwx4';
    
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);
        
        
        $response = $client->post('blogPosts', [
            'json' => $blogPostData
        ]);

        $blogPost = json_decode($response->getBody());

        $userReponse = $client->get('/users/'. $userId);
        
        $user = json_decode($userReponse->getBody());

        Session::flash("successMessage", "Changes have been saved.");
        return view('templates.article')->with((compact('blogPost', 'user')));

    }

    public function deleteBlogPost(Request $request){
        $blogPostId = $request->input('deleteBlogId');
        $blogPostTitle = $request->input('deleteBlogTitle');
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q0YjI4ZWEyNDk5YjBhZDA2YWE3NTkiLCJpYXQiOjE1NTc0NDMyMTR9.3UZ9hFtBtWgO5J5IG8Ftg85l-mwBIFxr_sVXQMfKwx4';
    
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
      
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q0YjI4ZWEyNDk5YjBhZDA2YWE3NTkiLCJpYXQiOjE1NTc0NDMyMTR9.3UZ9hFtBtWgO5J5IG8Ftg85l-mwBIFxr_sVXQMfKwx4';
    
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

        $blogPostData = [
            'author' => $request->input('author'),
            'title' => $request->input('title'),
            'synopsis' => $request->input('synopsis'),
            'category' => $request->input('category'),
            'isFree' => $request->input('isFree'),
            'status' => $request->input('status'),
            'body' => $request->input('body')
        ];
 
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q0YjI4ZWEyNDk5YjBhZDA2YWE3NTkiLCJpYXQiOjE1NTc0NDMyMTR9.3UZ9hFtBtWgO5J5IG8Ftg85l-mwBIFxr_sVXQMfKwx4';
    
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);

        $response = $client->patch('/blogPosts/' . $blogPostId, [
            'json' => $blogPostData
        ]);

        Session::flash("successMessage", "Changes have been successfully saved!");
        // $blogPost = json_decode($response->getBody());
        // $userId = Session::get('_id');
        // $response2 = $client->get('/users/'. $userId);
        // $user = json_decode($response2->getBody());
        return Redirect::back();
    }
}
