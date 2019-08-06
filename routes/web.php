<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('vue.test');
});

Auth::routes();

Route::post('/api/login',function (Request $request) {
    return Auth::attempt($request->only(['email','password']));
});

Route::post('/api/user/add',function (Request $request) {
    $credentials = $request->only(['email','password','name','role']);
    $user = new User();
    $user->email = $credentials['email'];
    $user->password = Hash::make($credentials['password']);
    $user->name = $credentials['name'];
    $user->role = $credentials['role'];
    return $user->save();
});

Route::get('/avito', function () {
   $avito = new \App\Services\AvitoParsingService();
});
