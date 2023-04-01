<?php

use App\Events\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FollowController;

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


//for admin onyl
Route::get('/admin',[AdminController::class,"AdminPage"])->middleware('can:visitAdminPages');

// User related routes
Route::get('/',[UserController::class,"showCorrectHomepage"])->name('login');
Route::post('/logout',[UserController::class,"Logout"])->middleware('loggedin');
Route::post('/login',[UserController::class,"Login"])->middleware('guest');
Route::post('/register',[UserController::class,"Register"])->middleware('loggedin');

//For Guest Page
Route::get('/about',[ExampleController::class,"AboutPage"]);
Route::get('/contact',[ExampleController::class,"Contact"]);

// User blog post related
Route::get('/single-post',[ExampleController::class,"SinglePost"])->middleware('loggedin');
Route::get('/create-post',[PostController::class,"showCreateForm"])->middleware('loggedin');
Route::post('/create-post',[PostController::class,"storeNewPost"])->middleware('loggedin');
Route::get('/post/{post}',[PostController::class,"showSinglePost"])->middleware('loggedin');
Route::delete('/post/{post}',[PostController::class,"DeletePost"])->middleware('can:delete,post');
Route::get('/post/{post}/edit',[PostController::class,"showEditForm"])->middleware('can:update,post');
Route::put('/post/{post}',[PostController::class,'UpdatePost'])->middleware('can:update,post');
Route::get('/search/{term}',[PostController::class,"search"])->middleware('loggedin');

//User Profile

Route::get('/manage-avatar/{profile}',[UserController::class,"ManageAvatar"])->middleware('loggedin');
Route::post('/manage-avatar',[UserController::class,"StoreAvatar"])->middleware('loggedin');
//User profile main page
Route::get('/profile/{profile:id}',[UserController::class,"Profile"])->middleware('loggedin');
Route::get('/profile/{profile}/followers',[UserController::class,"Followers"])->middleware('loggedin');
Route::get('/profile/{profile}/followed',[UserController::class,"Followed"])->middleware('loggedin');

//Visit profile using json 
//User profile main page
Route::get('/profile/{profile}/raw', [UserController::class, 'ProfileRaw']);
Route::get('/profile/{profile}/followers/raw', [UserController::class, 'FollowersRaw']);
Route::get('/profile/{profile}/followed/raw', [UserController::class, 'FollowedRaw']);

//Follow relate routes
Route::post('/create-follow/{user:username}',[FollowController::class,"createFollow"])->middleware('loggedin');
Route::post('/remove-follow/{user:username}',[FollowController::class,"removeFollow"])->middleware('loggedin');

//chat route
Route::post('/send-chat-message',function (Request $request){
    $formFields = $request->validate([
        'textvalue'=> 'required'
    ]);
    if(!trim(strip_tags($formFields['textvalue']))){
        return response()->noContent();
    }
    broadcast(new ChatMessage(['username'=>auth()->user()->username,'textvalue'=>strip_tags($request->textvalue),'avatar'=>auth()->user()->avatar]))->toOthers();
    return response()->noContent();
}
)->middleware('loggedin');




//back button
Route::get('/back',[PostController::class,'Back']);