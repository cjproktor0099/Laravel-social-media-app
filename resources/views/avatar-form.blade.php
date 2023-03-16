<x-layout doctitle="Manage Avatar">
    <div class="container py-md-5 container--narrow">
        <h2 class="text-center mb-3">Upload New Avatar</h2>
        <form action="/manage-avatar" method="POST" enctype="multipart/form-data">
            @csrf
          <div class="mb-3">
            <input  name="avatar"  type="file"/>
            @error('avatar') 
            <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p> 
           @enderror
          </div>
  
  
          <button class="btn btn-primary">Save</button>
        </form>
      </div>
</x-layout>