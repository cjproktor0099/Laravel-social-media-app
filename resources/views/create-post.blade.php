<x-layout doctitle="Create New Post">
    <div class="container py-md-5 container--narrow">
        <form action="/create-post" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <label for="image-post" class="text-muted mb-1"><small>Attach Photo</small></label>
              <input  name="image_post" id="image-post" class="form-control form-control-sm" type="file" />
              @error('image-post') 
              <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p> 
             @enderror
            </div>
          <div class="form-group">
            <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
            <input  name="title" id="post-title" class="form-control form-control-lg form-control-title" type="text" placeholder="" autocomplete="off" value="{{old('title')}}"/>
            @error('title') 
            <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p> 
           @enderror
          </div>
  
          <div class="form-group">
            <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
            <textarea  name="body" id="post-body" class="body-content tall-textarea form-control" type="text" >{{old('body')}}</textarea>
            @error('body') 
            <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p> 
           @enderror
          </div>
  
          <button class="btn btn-primary">Save New Post</button>
        </form>
      </div>
</x-layout>