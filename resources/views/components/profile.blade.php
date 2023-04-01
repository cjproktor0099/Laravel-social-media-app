<x-layout :doctitle="$doctitle">

    <div class="container py-md-5 container--narrow">
        <h2>
          <img class="avatar-small" src="{{$sharedData['avatar']}}" />
          {{$sharedData['username']}}
      
          @if(!$sharedData['alreadyFollow']and auth()->user()->username !== $sharedData['username'])
          <form class="ml-2 d-inline" action="/create-follow/{{$sharedData['username']}}" method="POST">
            @csrf
            <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
          </form>
          @endif 
          @if($sharedData['alreadyFollow'])
          <form class="ml-2 d-inline" action="/remove-follow/{{$sharedData['username']}}" method="POST">
            @csrf
           <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
          </form>
          @endif 
          @if(auth()->user()->username == $sharedData['username'])
            <!--<i class="fas fa-file-upload"></i> -->
            <a href="/manage-avatar/{{auth()->user()->id}}" class="btn-secondary btn-sm">Manage Avatar</a>
            @endif 
        </h2>
  
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="/profile/{{$sharedData['id']}}" class="profile-nav-link nav-item nav-link {{ Request::segment(3) == "" ? "active" : "" }}" >Posts: {{$sharedData['countposts']}}</a>
          <a href="/profile/{{$sharedData['id']}}/followers" class="profile-nav-link nav-item nav-link {{ Request::segment(3) == "followers" ? "active" : "" }}">Followers: {{$sharedData['countuserfollowed']}}</a>
          <a href="/profile/{{$sharedData['id']}}/followed" class="profile-nav-link nav-item nav-link {{ Request::segment(3) == "followed" ? "active" : "" }}">Following: {{$sharedData['countfollowers']}}</a>
        </div>
        
     
        <div class="profile-slot-content">
          {{$slot}}
        </div>

      </div>
  
</x-layout>