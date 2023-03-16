<x-layout>


    <div class="container py-md-5 container--narrow">
      @unless($posts->isEmpty())

      <!--Followed user posts-->
      @foreach ($posts as $post)
      <div class="posted-username"><a href="/profile/{{$post->user->id}}"><img class="avatar-tiny" src="{{$post->user->avatar}}" /></a>
          <a href="/profile/{{$post->user->id}}">{{$post->user->fullname}}</a>
      </div> 
      <p class="text-muted small mb-1">  Posted on {{$post->created_at->format('M-d-Y')}}</p>

      <div class="body-content">
        <p>{!! $post->body !!}</p>
        @if(!$post->image_post == NULL)
          <img class="image-post" src="{{"/storage/user-posts/".$post->image_post}}" />
       @endif
      </div>

      <div class="footer-content">
        <a href="/like/{{$post->id}}"><i class="fas fa-thumbs-up"></i>Like</a>
      </div>
      @endforeach
      <!--ENd Followed user posts-->
      <div class="mt-4">
        {{$posts->links()}}
      </div>

      @else
        <div class="text-center">
          <h2>Hello <strong>{{auth()->user()->username}}</strong>, your feed is empty.</h2>
          <p class="lead text-muted">Your feed displays the latest posts from the people you follow. If you don&rsquo;t have any friends to follow that&rsquo;s okay; you can use the &ldquo;Search&rdquo; feature in the top menu bar to find content written by people with similar interests and then follow them.</p>
        </div>
      @endunless
    </div>  

</x-layout>