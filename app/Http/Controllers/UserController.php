<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use App\Events\OurExampleEvent;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

       public function showCorrectHomepage(){
             if( auth()->check()){
                     return  view('homepage-feed',['posts'=>auth()->user()->feedPosts()->latest()->paginate(5)]);
             }else{
                     return  view('homepage');
             }
       }



       public function Logout(Request $request)
       {
              event(new OurExampleEvent(['username'=> auth()->user()->username, 'action' => 'logout']));
              auth()->logout();
              
              return redirect('/')->with('success','Your are now successfully Logged out');
       }

       public function Login(Request $request)
       {
                    $incoming_fields = $request->validate(
                           [
                                  'loginusername' => 'required',
                                  'loginpassword' => 'required'
                           ] );
                    if (auth()->attempt(['username'=> $incoming_fields['loginusername'], 'password'=> $incoming_fields['loginpassword']])) {
                     event(new OurExampleEvent(['username'=> auth()->user()->username, 'action' => 'loggein']));
                     return redirect('/')->with('success','Your are now successfully Logged in');
                    } else {
                     return redirect('/')->with('wrong','Wrong username and password');
                    }
                    
      
       }

//Register Account
 public function Register(Request $request)
 {
              $incoming_fields = $request->validate(
                     [
                            'username' => ['required','min:6','max:16',Rule::unique('users','username')],
                            'fullname' => 'required',
                            'email' => ['required','email',Rule::unique('users','email')],
                            'password' => ['required','min:8','confirmed']
                     ] );
              $incoming_fields['password'] = bcrypt($incoming_fields['password']);
              $user =  User::create($incoming_fields);
              auth()->login($user);
              return redirect('/')->with('success','Successfully Register');
 }


 //Show user Profile Page
private function getSharedData($profile){
       if(auth()->check()){
       $existCheck = Follow::where([['user_id','=', auth()->user()->id], ['followeduser','=', $profile->id]])->count();
        
       View::share('sharedData',
       ['username' =>$profile->username,
       'posts'=> $profile->posts()->get(),
       'id' =>$profile->id,
       'avatar' =>$profile->avatar,
       'countposts'=> $profile->posts()->count(),
       'countfollowers'=> $profile->followed()->count(),
       'countuserfollowed'=> $profile->followers()->count(),
       'alreadyFollow'=> $existCheck,
       'UserFollowers'=> $profile->followers()->get()
       ]);
        }}      

 public function Profile (User $profile){
       $this->getSharedData($profile);
       return view('profile-posts',['posts'=> $profile->posts()->get()] );}
 public function Followers (User $profile){
       $this->getSharedData($profile);
       return view('profile-followers',['followers'=> $profile->followers()->latest()->get()]);
}
 public function Followed (User $profile){
       $this->getSharedData($profile);
       return view('profile-followed',['followed'=> $profile->followed()->latest()->get()]);}


       
       public function ProfileRaw (User $profile){
              return response()->json(['theHTML' => view('profile-post-only', ['posts' => $profile->posts()->latest()->get()])->render(), 'doctitle' => $profile->username . "'s Profile"]);
              }
              
        public function FollowersRaw (User $profile){
              return response()->json(['theHTML' => view('profile-followers-only', ['followers' => $profile->followers()->latest()->get()])->render(), 'doctitle' => $profile->username . "'s Followers"]);
       }
        public function FollowedRaw (User $profile){
              return response()->json([
                     'theHTML' => view('profile-followed-only', ['followed'=> $profile->followed()->latest()->get()])->render(),
                     'doctitle' => $profile->fullname."'s Followers"]);}



 public function ManageAvatar (User $profile){
       $avatar = $profile->avatar;
       return view('avatar-form',['avatar'=>$profile->avatar]);
}


public function StoreAvatar (Request $request){
      $request->validate([
              'avatar' => 'required|image|max:3000'
       ]);
       $user = auth()->user();
       $oldAvatar = $user->avatar;
       $filename = $user->id. '-'. uniqid().'.jpg';
       $imageFile = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
       Storage::put('public/avatars/'.$filename, $imageFile);
       $user->avatar = $filename;
       $user->save();
       if($oldAvatar != "/fallback-avatar.jpg") {
              Storage::delete(str_replace("/storage/","public/", $oldAvatar));
       }
       return redirect('/profile/'.$user->id)->with('success','Avatar Successfully uploaded');
       
}
}
