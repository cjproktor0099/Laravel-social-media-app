<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function search($term){
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }
    public function Back(){
        return back();
    }
    public function showEditForm (Post $post){
        return view('edit-post',['post'=>$post]);

    }
    public function  UpdatePost(Post $post, Request $request){
        $incoming_fields = $request->validate(
            [
                'title' => 'required',
                'body' => 'required'
            ]);
        $incoming_fields['title'] = strip_tags($incoming_fields['title']);
        $incoming_fields['body'] = strip_tags($incoming_fields['body']);
        $post->update($incoming_fields);
        return back()->with('success','New post Successfully updated');

    }
    public function DeletePost (Post $post){
        //Policy Delete in controller
        //if (auth()->user()->cannot('delete',$post)){
            //return redirect('/')->with('wrong',"You don't have a permision to perform this action");
            //return view('single-post',['post'=>$post])->with('failure','You dont have permission to delete this post');  
        //}
         $post->delete();
         return redirect('/profile/'. auth()->user()->id)->with('success','Post successfully deleted');
        //$post_id -> delete();
        //return redirect('/')->with('success','1 Post successfully deleted');

    }

    public function showSinglePost(Post $post){
        
        //if($post->user_id === auth()->user()->id){
            $post['body'] = strip_tags(Str::markdown($post->body),'<p><b><h3><li><ol><strong><em>');
            return view('single-post',['post'=>$post]);
       // } 
            //return "You have permission to access this post";
        
       
        
    }

    public function showCreateForm()
    {
        return view('create-post');
    }

    public function storeNewPost(Request $request)
    {
        $incoming_fields = $request->validate(
            [
                'title' => 'required',
                'body' => 'required',
                'image_post' => 'required|image|max:3000'
            ]
        );
        $user = auth()->user();
        $filename = $user->id. '-'. uniqid().'.jpg';
        $imageFile = Image::make($request->file('image_post'))->fit('240')->encode('jpg');
        Storage::put('public/user-posts/'.$filename, $imageFile);
        $incoming_fields['image_post'] =  $filename;
        $incoming_fields['title'] = strip_tags($incoming_fields['title']);
        $incoming_fields['body'] = strip_tags($incoming_fields['body']);
        $incoming_fields['user_id'] = auth()->id();
 

        $newPost = Post::create($incoming_fields);
        return redirect("/post/{$newPost->id}")->with('success','New post Successfully created');
    }

    //Delete User Post 


}