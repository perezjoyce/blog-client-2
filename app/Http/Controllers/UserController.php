<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Session;
use Illuminate\Validation\Validator;
use BlogPostController;
use Redirect;

class UserController extends Controller
{   
    //DISPLAY DASHBOARD
    public function getDashboard(Request $request) {

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
        // dd($userId);

        $response = $client->get('/users/'. $userId);
        // dd($response);

        $user = json_decode($response->getBody());
        $response2 = $client->get('/finalBlogPosts');
        $blogPosts = json_decode($response2->getBody());

        //OBFUSCATE EMAIL
        $email = $user->email;
        $mail_parts = explode("@", $email);
        $length = strlen($mail_parts[0]);
        $show = floor($length/2);
        $hide = $length - $show;
        $replace = str_repeat("*", $hide);
        $hiddenEmail = substr_replace ( $mail_parts[0] , $replace , $show, $hide ) . "@" . substr_replace($mail_parts[1], "**", 0, 2);

        return view('user.dashboard')->with(compact('user', 'blogPosts', 'hiddenEmail'));
    }

    public function displayAllUsers(Request $request){
        //$token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2Q4ZTk0NDUwNjM4MDI3YjAzOWIwYWQiLCJpYXQiOjE1NTc3MTkzNjR9.GgLecg32XQxU5dzo6zIGLfFAJN8NGbelb7YI4qx8Wm0';
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
            $response = $client->get('/allUsers');
            $blogUsers = json_decode($response->getBody());
            return view('templates.user-list')->with(compact('user', 'blogUsers'));
        } 
    }

    //CREATE AND LOGIN USER
    public function createUser(Request $request) {

        // REGISTER
        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

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
        
        $response = $client->post('users', [
            'json' => $userData
        ]);

        // LOGIN
        $userData = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);
        
        try {
            $response = $client->post('/users/login', [
                'json' => $userData
            ]);
 
            //DISPLAY PROFILE
            $userResponse = json_decode($response->getBody());

            if ($userResponse) {
                $userToken = $userResponse->token;
                $userId = $userResponse->user->_id;
                $request->session()->put('token', $userToken);
                $request->session()->put('_id', $userId);
                Session::flash("successMessage", "Welcome to MAM, " . $userResponse->user->name ."! :)");
                return Redirect::back();
            }

            Session::flash("errorMessage", "Invalid user credentials.");
            return Redirect::back();
        } catch (\Exception $e) {
            Session::flash("errorMessage", "Invalid user credentials.");
            return Redirect::back();
        }
    }    

    //LOGIN USER
    public function loginUser(Request $request) {
        $userData = [
            'email' => $request->input('login-email'),
            'password' => $request->input('login-password')
        ];

        $headers = [
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);
        
        try {
            $response = $client->post('/users/login', [
                'json' => $userData
            ]);
 
            //DISPLAY PROFILE
            $userResponse = json_decode($response->getBody());

            if ($userResponse) {
                $userToken = $userResponse->token;
                $userId = $userResponse->user->_id;
                $request->session()->put('token', $userToken);
                $request->session()->put('_id', $userId);
                Session::flash("successMessage", "Hello, " . $userResponse->user->name ."! :)");
                return Redirect::back();
            }

            Session::flash("errorMessage", "Invalid user credentials.");
            return Redirect::back();
        } catch (\Exception $e) {
            Session::flash("errorMessage", "Invalid user credentials.");
            return Redirect::back();
        }
    }

    //LOGOUT 
    public function logoutUser(Request $request) {

        $userId = Session::get('_id');

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
        
      
        $response = $client->post('/users/logout/' . $userId);
        $request->session()->forget(['token','_id']); 
        Session::flash("successMessage", "You are now logged out!");
        return redirect('/');
    }

    //DEACTIVATE 
    public function deleteUser(Request $request) {

        $userData = [
            'email' => $request->input('deactivation-email'),
            'password' => $request->input('deactivation-password')
        ];

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

        try {
            $response = $client->put('/users/me', [
                'json' => $userData
            ]);
            $request->session()->forget(['token','_id']);
            Session::flash("successMessage", "Your account has been deactivated.");
            return redirect('/');
        } catch (\Exception $e) {
            $response = $client->get('/users/me');
            $user = json_decode($response->getBody());
            Session::flash("errorMessage", "Invalid user credentials.");
            return redirect('/dashboard');
        }
    }

    //EDIT USER
    public function editUser(Request $request) {

        $userData = [
            'name' => $request->input('edit_name'),
            'email' => $request->input('edit_email'),
            '_id' => $request->input('userId'),
            'plan' => $request->input('edit_plan'),
            'isAdmin' => $request->input('edit_role')
        ];

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

        try {
            
            if ($userId === $userData['_id']) {
                $response = $client->patch('/users/'. $userData['_id'], [
                    'json' => $userData
                ]);
                Session::flash("successMessage", "Your account has been successfully updated.");
                return redirect('/dashboard');
            } 

            $response = $client->patch('/users/'. $userData['_id'] . '/admin', [
                'json' => $userData
            ]);
            // dd($response);
            Session::flash("successMessage", "The account of " . $userData['name'] . " has been successfully updated.");
            return Redirect::back();
            
        } catch (\Exception $e) {
            // $response = $client->get('/users/me');
            Session::flash("errorMessage", "Invalid user credentials.");
            return Redirect::back();
        }
    }

    public function subscription(Request $request) {

        $token = $request->session()->get('token');
        $userId = $request->session()->get('id');
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);

        try {
            $response = $client->post('/users/me/subscribe', [
                "json" => [
                    'stripeToken' => $request->input('stripeToken')
                ]
            ]);

            $userResponse = json_decode($response->getBody());

            // dd($userResponse);
            Session::flash("successMessage", "Your account has been updated to premium.");
            return Redirect::back();


        } catch(\Exception $e) {
            Session::flash("errorMessage", "Invalid account.");
            return Redirect::back();
        }
    }

}
