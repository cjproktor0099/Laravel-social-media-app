<x-layout :doctitle="$post->title">
  {{-- layout name is from components --}}


  {{-- slot mention in layout --}}


  <div class="container py-md-5 container--narrow">
    <div class="d-flex justify-content-between">
      <h2>{{$post->title}}</h2>
      @can('update', $post)
      <span class="pt-2">
        <a href="/post/{{$post->id}}/edit" class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
        <form class="delete-post-form d-inline" action="/post/{{$post->id}}" method="POST">
          @csrf
          @method('DELETE')
          <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
        </form>
      </span>
      @endcan
    </div>

    <p class="text-muted small mb-4">
      <a href="#"><img class="avatar-tiny" src="{{$post->user->avatar}}" /></a>
      
      Posted by <a href="#">{{$post->user->fullname}}</a> on {{$post->created_at->format('M-d-Y')}}
    </p>

    <div class="body-content">
      
      <p>{!! $post->body !!}</p>
      @if(!$post->image_post == NULL)
        <img class="image-post" src="{{"/storage/user-posts/".$post->image_post}}" />
      @endif
      
    </div>
    <div class="footer-content">
      <a href="/like/{{$post->id}}"><i class="fas fa-thumbs-up"></i>Like</a>
    </div>
  </div>


</x-layout>