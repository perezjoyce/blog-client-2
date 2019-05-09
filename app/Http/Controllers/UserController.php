<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

class UserController extends Controller
{   
    
    //CREATE AND LOGIN USER
    public function createUser(Request $request) {

        $userData = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2QyMDY5MTc0NzIzMzc2NjQzZDUxNjEiLCJpYXQiOjE1NTcyNjgxMTN9.s4rmFMBVF9SncjEie8WjDOxEgKZUS20HOVMIEmo7zbo';
    
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
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2QyMDY5MTc0NzIzMzc2NjQzZDUxNjEiLCJpYXQiOjE1NTcyNjgxMTN9.s4rmFMBVF9SncjEie8WjDOxEgKZUS20HOVMIEmo7zbo';
    
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);
        
        $response = $client->post('users/login', [
            'json' => $userData
        ]);

        //DISPLAY PROFILE
        $user = json_decode($response->getBody());
        return view('user.dashboard')->with(compact('user'));
    }

    //LOGOUT -- not working
    public function logoutUser(Request $request) {

        $userData = [
            '_id' => $request->input('_id'),
        ];

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2QyMDY5MTc0NzIzMzc2NjQzZDUxNjEiLCJpYXQiOjE1NTcyNjgxMTN9.s4rmFMBVF9SncjEie8WjDOxEgKZUS20HOVMIEmo7zbo';
    
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);
        
        // $client->postAsync('users/logout', [
        //     'json' => $userData
        // ]);

        $client->request('POST', 'users/logout');
        return redirect('/');
    }

    //DELETE -- not working
    public function deleteUser(Request $request) {

        $userData = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2QyMDY5MTc0NzIzMzc2NjQzZDUxNjEiLCJpYXQiOjE1NTcyNjgxMTN9.s4rmFMBVF9SncjEie8WjDOxEgKZUS20HOVMIEmo7zbo';
        
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ];

        $client = new Client([
            'base_uri' => 'http://127.0.0.1:3000',
            'timeout'  => 2.0,
            'headers' => $headers
        ]);

        $client->deleteAsync('users/me', [
            'json' => $userData
        ]);

        return redirect('/');
    }

}
