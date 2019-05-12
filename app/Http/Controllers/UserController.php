<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;
use Session;
use Illuminate\Validation\Validator;

class UserController extends Controller
{   
    //DISPLAY DASHBOARD
    public function getDashboard() {
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
        // dd($userId);

        $response = $client->get('/users/'. $userId);

        $user = json_decode($response->getBody());

        return view('user.dashboard')->with(compact('user'));
    }

    //CREATE AND LOGIN USER
    public function createUser(Request $request) {

        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
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
        
        //CREATE USER
        $response = $client->post('users', [
            'json' => $userData
        ]);

        //DISPLAY PROFILE
        // $userData = json_decode($response->getBody());
        // return view('user.dashboard')->with(compact('userData'));
        return redirect('/');
    }    

    //LOGIN USER
    public function loginUser(Request $request) {
        $userData = [
            'email' => $request->input('login-email'),
            'password' => $request->input('login-password')
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
                Session::flash("successMessage", "Hello, " . $userResponse->user->name);
                return redirect('/dashboard');
            }

            Session::flash("errorMessage", "Invalid user credentials.");
            return redirect('/');
        } catch (Exception $e) {
            Session::flash("errorMessage", "Invalid user credentials.");
            return redirect('/');
        }
    }

    //LOGOUT 
    public function logoutUser(Request $request) {

        $request->session()->forget(['token','_id']); //forget userToken and userId
        Session::flash("successMessage", "You are now logged out!");
        return redirect('/');
    }

    //DEACTIVATE 
    public function deleteUser(Request $request) {

        $userData = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
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

        try {
            $response = $client->put('/users/me', [
                'json' => $userData
            ]);
            $request->session()->forget(['token','_id']);
            Session::flash("successMessage", "Your account has been deactivated.");
            return redirect('/');
        } catch (Exception $e) {
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
            '_id' => $request->input('userId'),
            'plan' => $request->input('edit_plan'),
            'password' => $request->input('edit_password')
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

        try {
            $response = $client->patch('/users/'. $userData['_id'], [
                'json' => $userData
            ]);
            
            Session::flash("successMessage", "Your account has been successfully updated.");
            return redirect('/dashboard');

        } catch (Exception $e) {
            $response = $client->get('/users/me');
            Session::flash("errorMessage", "Invalid user credentials.");
            return redirect('/dashboard');
        }
    }
}
