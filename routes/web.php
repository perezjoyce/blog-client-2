<?php
use GuzzleHttp\Client;
use App\Http\Controllers\UserController;

//HOME PAGE
Route::get('/', function () {
    $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI1Y2QyMDY5MTc0NzIzMzc2NjQzZDUxNjEiLCJpYXQiOjE1NTcyNjgxMTN9.s4rmFMBVF9SncjEie8WjDOxEgKZUS20HOVMIEmo7zbo';
    
    $headers = [
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json'
    ];

    $client = new Client([
        'base_uri' => 'http://127.0.0.1:3000',
        'timeout'  => 2.0,
    ]);

    return view('welcome');

    // $response = $client->request('GET', 'users/me', [
    //     'headers' => $headers
    // ]);
    
    // $jsonCurrentUser = json_decode($response->getBody());
    
    // dd($jsonCurrentUser);
    // echo "<h1>" . $jsonCurrentUser->name . "</h1>";
    // echo "<h1>" . $jsonCurrentUser->email . "</h1>";
});

Route::get('register', function () {
    return view('templates.register');
})->name('register');

Route::post('create-user', 'UserController@createUser');

Route::post('login-user', 'UserController@loginUser');

Route::post('logout' , 'UserController@logoutUser')->name('logout');

Route::delete('delete-user', 'UserController@deleteUser');
