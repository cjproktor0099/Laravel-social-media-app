<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
   public function createFollow(User $user){
    //You cannot follow your self
    if ($user->id == auth()->user()->id){
        return  back()->with('wrong','You cannot perform this action');
    }   
    //You cannot follow you already follow
    $existCheck = Follow::where([['user_id','=', auth()->user()->id], ['followeduser','=', $user->id]])->count();

    if($existCheck){
        return back()->with('wrong','You are already following'.' '.$user->fullname);
    }
    $newFollow = new Follow;
     //   store $newFollow->user_id = auth()->user()->id value as loggedin user in user_id column 
    $newFollow->user_id = auth()->user()->id;
     //   store $newFollow->user_id = auth()->user()->id value as visitted account user in followed user column 
    $newFollow->followeduser = $user->id;
    $newFollow->save();
    return back()->with('success','You followed '.$user->fullname.' successfully');
   }
   public function removeFollow(User $user){
    Follow::where([['user_id','=', auth()->user()->id], ['followeduser','=', $user->id]])->delete();
    return back()->with('success', 'You have successfully unfollowed '.$user->fullname);
   }

}
